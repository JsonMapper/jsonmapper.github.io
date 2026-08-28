<?php

declare(strict_types=1);

namespace App\Actions;

use Hyde\Hyde;
use Hyde\Support\Filesystem\MediaFile;
use Illuminate\Support\Facades\File;
use Hyde\Framework\Features\BuildTasks\PostBuildTask;

/**
 * Also publish the favicon at the site root.
 *
 * Hyde copies media to _site/media/, and its head layout links media/favicon.ico
 * explicitly, which modern browsers honour. But browsers also request
 * /favicon.ico implicitly, and that is where the previous Jekyll site served it,
 * so anything still holding the old location would get a 404. Copying it to the
 * root costs 15 KB and removes that whole class of problem.
 */
class CopyRootFaviconBuildTask extends PostBuildTask
{
    protected static string $message = 'Publishing the favicon at the site root';

    public function handle(): void
    {
        // Media assets are transferred before post-build tasks run, so the
        // already-copied file in the output directory is the source here.
        $source = MediaFile::outputPath('favicon.ico');

        if (! File::exists($source)) {
            $this->skip('There is no favicon.ico in the media directory.');
        }

        File::copy($source, Hyde::sitePath('favicon.ico'));

        $this->createdSiteFile(Hyde::sitePath('favicon.ico'));
    }
}
