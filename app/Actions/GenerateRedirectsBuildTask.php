<?php

declare(strict_types=1);

namespace App\Actions;

use Hyde\Hyde;
use Hyde\Facades\Filesystem;
use Hyde\Support\Models\Redirect;
use Hyde\Foundation\Facades\Routes;
use Hyde\Framework\Features\BuildTasks\PostBuildTask;

use function sprintf;
use function array_key_exists;

/**
 * Keep the URLs the site used before it was migrated from Jekyll to HydePHP working.
 *
 * Under Jekyll every page declared its own `permalink` and lived at
 * /docs/<section>/<page>. Hyde flattens documentation output, so the same pages
 * are now served from /docs/<page>. This task emits a meta-refresh page at each
 * of the old locations so existing links, bookmarks and search results still
 * resolve.
 *
 * Hyde 2 has no `redirects` configuration option (that arrived in Hyde 3), and
 * Redirect pages are not autodiscoverable, so they are created here instead.
 */
class GenerateRedirectsBuildTask extends PostBuildTask
{
    protected static string $message = 'Generating redirects for pre-migration URLs';

    /**
     * Old URL path => new root-relative destination.
     *
     * Destinations must be root-relative: the redirect view prints them verbatim,
     * so a bare route key would resolve against the old page's own directory.
     *
     * /docs/architecture is deliberately absent. Its URL did not change, and
     * writing a redirect there would overwrite the real page with a self-redirect.
     *
     * @var array<string, string>
     */
    protected const REDIRECTS = [
        // The site root is not listed here. It is a real page,
        // _pages/index.blade.php, so that `hyde serve` can resolve it.
        'docs/usage/installation' => '/docs/installation',
        'docs/usage/setup' => '/docs/setup',

        'docs/guides/getting-started' => '/docs/getting-started',
        'docs/guides/creating-middleware' => '/docs/creating-middleware',
        'docs/guides/laravel-usage' => '/docs/laravel-usage',
        'docs/guides/symfony-usage' => '/docs/symfony-usage',

        'docs/middleware/typed-properties' => '/docs/typed-properties',
        'docs/middleware/doc-block-annotations' => '/docs/doc-block-annotations',
        'docs/middleware/namespace-resolver' => '/docs/namespace-resolver',
        'docs/middleware/constructor' => '/docs/constructor',
        'docs/middleware/case-conversion' => '/docs/case-conversion',
        'docs/middleware/debugging' => '/docs/debugging',
        'docs/middleware/final-callback' => '/docs/final-callback',
        'docs/middleware/rename' => '/docs/rename',
        'docs/middleware/value-transformation' => '/docs/value-transformation',
        'docs/middleware/attributes' => '/docs/attributes',
        'docs/middleware/laravel-eloquent' => '/docs/laravel-eloquent',

        'docs/advanced/performance' => '/docs/performance',
        'docs/advanced/casting-values' => '/docs/casting-values',
        'docs/advanced/interfaces' => '/docs/interfaces',
        'docs/advanced/abstracts' => '/docs/abstracts',
    ];

    public function handle(): void
    {
        $outputPaths = $this->generatedOutputPaths();

        foreach (self::REDIRECTS as $path => $destination) {
            foreach ($this->pathVariants($path) as $variant) {
                $this->guardAgainstOverwritingPage($variant, $outputPaths);

                // Redirect::store() writes the file directly, and the flattened
                // documentation output means the old nested directories do not exist.
                Filesystem::ensureParentDirectoryExists(Hyde::sitePath("$variant.html"));

                Redirect::create($variant, $destination, false);

                $this->createdSiteFile(Hyde::sitePath("$variant.html"));
            }
        }
    }

    /**
     * Jekyll wrote some permalinks as <page>.html and others, where the permalink
     * had a trailing slash, as <page>/index.html. GitHub Pages serves /foo from
     * foo.html but /foo/ only from foo/index.html, so both spellings of every old
     * URL are emitted rather than trying to track which pages used which.
     *
     * @return array<string>
     */
    protected function pathVariants(string $path): array
    {
        return [$path, "$path/index"];
    }

    /**
     * A redirect whose path collides with a real page would replace that page
     * with a redirect to itself, so fail loudly rather than silently break it.
     *
     * @param  array<string, true>  $outputPaths
     */
    protected function guardAgainstOverwritingPage(string $path, array $outputPaths): void
    {
        if (array_key_exists("$path.html", $outputPaths)) {
            throw new \RuntimeException(sprintf(
                'Redirect "%s" would overwrite the generated page at "%s.html".', $path, $path
            ));
        }
    }

    /** @return array<string, true> */
    protected function generatedOutputPaths(): array
    {
        $paths = [];

        foreach (Routes::all() as $route) {
            $paths[$route->getOutputPath()] = true;
        }

        return $paths;
    }
}
