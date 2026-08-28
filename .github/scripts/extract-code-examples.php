#!/usr/bin/env php
<?php

/**
 * Extracts the documentation's PHP code blocks into analysable files.
 *
 * Two things make the output more useful than a naive dump:
 *
 * 1. Every line keeps its markdown line number. Lines outside a code fence
 *    become blank lines, so PHPStan's "line 27" is line 27 of the markdown and
 *    no line map is needed to report a useful location.
 * 2. Each page gets its own namespace. Several pages define their own `User`
 *    for the example to map onto, and analysing them together would otherwise
 *    collide.
 *
 * A page's fences are treated as one file, because pages routinely define the
 * class in one fence and map onto it in the next.
 *
 * Usage: extract-code-examples.php <output-directory>
 */

declare(strict_types=1);

const SOURCES = ['_docs', 'resources/includes'];

$root = dirname(__DIR__, 2);
$outputDir = $argv[1] ?? null;

if ($outputDir === null) {
    fwrite(STDERR, "usage: extract-code-examples.php <output-directory>\n");
    exit(1);
}

/** A namespace segment per path component, so each page is isolated. */
function namespaceFor(string $relative): string
{
    $parts = preg_split('#[/\\\\]#', substr($relative, 0, -3)) ?: [];
    $parts = array_map(
        static fn (string $part): string => str_replace(' ', '', ucwords(str_replace(['-', '_', '.'], ' ', $part))),
        $parts
    );

    return 'DocExample\\' . implode('\\', $parts);
}

$files = [];
foreach (SOURCES as $source) {
    if (! is_dir("$root/$source")) {
        continue;
    }
    foreach (new RecursiveIteratorIterator(new RecursiveDirectoryIterator("$root/$source")) as $file) {
        if ($file->isFile() && $file->getExtension() === 'md') {
            $files[] = $file->getPathname();
        }
    }
}
sort($files);

$written = 0;
foreach ($files as $file) {
    $relative = substr($file, strlen($root) + 1);
    $lines = explode("\n", (string) file_get_contents($file));

    $out = [];
    $ownFiles = [];
    $inFence = false;
    $fence = [];
    $fenceStart = 0;
    $seenUse = [];

    foreach ($lines as $index => $line) {
        if (! $inFence) {
            $out[] = '';
            if (preg_match('/^```php\s*$/', $line)) {
                $inFence = true;
                $fence = [];
                $fenceStart = $index + 1;
            }
            continue;
        }

        if (preg_match('/^```\s*$/', $line)) {
            // A fence declaring its own namespace stands for a separate file in
            // the reader's application. It gets its own analysed file, keeping
            // the namespace it declares, rather than being merged into the page.
            $isOwnFile = false;
            foreach ($fence as $fenceLine) {
                if (preg_match('/^\s*namespace\s+/', $fenceLine)) {
                    $isOwnFile = true;
                    break;
                }
            }

            if ($isOwnFile) {
                $standalone = array_fill(0, count($lines), '');
                foreach ($fence as $offset => $fenceLine) {
                    $standalone[$fenceStart + $offset] = preg_match('/^<\?php\s*$/', trim($fenceLine))
                        ? ''
                        : $fenceLine;
                }
                $standalone[0] = '<?php declare(strict_types=1);';
                $ownFiles[] = implode("\n", $standalone);
            }

            foreach ($fence as $offset => $fenceLine) {
                $keep = ! $isOwnFile;

                if ($keep && preg_match('/^<\?php\s*$/', trim($fenceLine))) {
                    $keep = false;
                }

                // Repeating a `use` across fences of one page is correct in the
                // docs but a redeclaration once merged.
                if ($keep && preg_match('/^use\s+[^;]+;$/', trim($fenceLine))) {
                    if (isset($seenUse[trim($fenceLine)])) {
                        $keep = false;
                    } else {
                        $seenUse[trim($fenceLine)] = true;
                    }
                }

                $out[$fenceStart + $offset] = $keep ? $fenceLine : '';
            }

            $out[] = '';
            $inFence = false;
            continue;
        }

        $fence[] = $line;
        $out[] = '';
    }

    // Mirror the source tree so a reported path maps straight back to the page.
    foreach ($ownFiles as $index => $contents) {
        $target = $outputDir . '/' . $relative . '.' . $index . '.php';
        if (! is_dir(dirname($target))) {
            mkdir(dirname($target), 0777, true);
        }
        file_put_contents($target, $contents);
        $written++;
    }

    if (trim(implode('', $out)) === '') {
        continue;
    }

    // Line 1 of a markdown page is front matter or a fence marker, never code,
    // so the declaration can live there without shifting anything.
    $out[0] = '<?php declare(strict_types=1); namespace ' . namespaceFor($relative) . ';';

    $target = $outputDir . '/' . $relative . '.php';
    if (! is_dir(dirname($target))) {
        mkdir(dirname($target), 0777, true);
    }
    file_put_contents($target, implode("\n", $out));
    $written++;
}

echo "Extracted {$written} files of code blocks into {$outputDir}\n";
