#!/usr/bin/env php
<?php

/**
 * Lints the PHP code blocks embedded in the documentation.
 *
 * The package this site documents lives in a different repository, so nothing
 * here compiles the examples and a broken snippet ships unnoticed. Several did:
 * a builder constructed with a method that does not exist, a middleware missing
 * a required constructor argument, a mapper method handed a string where it
 * wants a \stdClass. Parse errors are the subset a linter can catch without the
 * package installed, so that is what this covers — it will not tell you an
 * example is wrong, only that it is not valid PHP.
 *
 * Each fenced block is linted on its own, because that is how a reader meets it.
 * Failures are reported against the markdown file and the line the fence starts
 * on, not the temporary file the linter actually saw.
 */

declare(strict_types=1);

const SOURCES = ['_docs', 'resources/includes'];

$root = dirname(__DIR__, 2);
$onCi = getenv('GITHUB_ACTIONS') === 'true';

/** Every markdown file under the documented source directories. */
function markdownFiles(string $root): array
{
    $files = [];
    foreach (SOURCES as $source) {
        $path = $root . '/' . $source;
        if (! is_dir($path)) {
            continue;
        }
        $iterator = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($path));
        foreach ($iterator as $file) {
            if ($file->isFile() && $file->getExtension() === 'md') {
                $files[] = $file->getPathname();
            }
        }
    }
    sort($files);

    return $files;
}

/**
 * Pull the ```php fences out of one file.
 *
 * @return array<int, array{line: int, code: string}> line is 1-indexed and
 *         points at the fence marker itself.
 */
function phpBlocks(string $markdown): array
{
    $blocks = [];
    $lines = explode("\n", $markdown);
    $open = null;
    $body = [];

    foreach ($lines as $index => $line) {
        if ($open === null) {
            if (preg_match('/^```php\s*$/', $line)) {
                $open = $index + 1;
                $body = [];
            }
            continue;
        }

        if (preg_match('/^```\s*$/', $line)) {
            $blocks[] = ['line' => $open, 'code' => implode("\n", $body)];
            $open = null;
            continue;
        }

        $body[] = $line;
    }

    return $blocks;
}

$files = markdownFiles($root);
$checked = 0;
$failures = [];

foreach ($files as $file) {
    $relative = substr($file, strlen($root) + 1);

    foreach (phpBlocks((string) file_get_contents($file)) as $block) {
        $code = ltrim($block['code'], "\n");

        // A block may or may not open with its own tag. Normalise to exactly one,
        // and remember whether that shifted the code down a line so the linter's
        // line numbers can be translated back to the markdown.
        if (preg_match('/^<\?php\s*$/m', strtok($code, "\n") ?: '')) {
            $offset = $block['line'];
        } else {
            $code = "<?php\n" . $code;
            $offset = $block['line'] - 1;
        }

        $temp = tempnam(sys_get_temp_dir(), 'doc-example-') . '.php';
        file_put_contents($temp, $code);

        exec(sprintf('%s -l %s 2>&1', escapeshellarg(PHP_BINARY), escapeshellarg($temp)), $output, $status);
        unlink($temp);
        $checked++;

        if ($status === 0) {
            $output = [];
            continue;
        }

        // php -l prints two lines: the diagnostic, then "Errors parsing <file>".
        // Keep the first, and translate its line number back into the markdown.
        $message = '';
        foreach ($output as $candidate) {
            if (str_contains($candidate, ' on line ')) {
                $message = $candidate;
                break;
            }
        }
        $message = $message !== '' ? $message : ($output[0] ?? 'could not be parsed');
        $output = [];

        $line = $block['line'];
        if (preg_match('/ on line (\d+)/', $message, $matches)) {
            $line = $offset + (int) $matches[1];
        }
        $message = preg_replace('/ in \S+ on line \d+/', '', $message) ?? $message;
        $message = trim(preg_replace('/^(PHP )?(Parse|Fatal) error:\s*/i', '', $message) ?? $message);

        $failures[] = ['file' => $relative, 'line' => $line, 'message' => $message];
    }
}

foreach ($failures as $failure) {
    $text = sprintf('%s:%d  %s', $failure['file'], $failure['line'], $failure['message']);
    echo $onCi
        ? sprintf("::error file=%s,line=%d::%s\n", $failure['file'], $failure['line'], $failure['message'])
        : $text . "\n";
}

if ($failures !== []) {
    printf("\n%d of %d code blocks in %d files failed to parse.\n", count($failures), $checked, count($files));
    exit(1);
}

printf("All %d PHP code blocks in %d files parse cleanly.\n", $checked, count($files));
