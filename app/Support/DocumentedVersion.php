<?php

declare(strict_types=1);

namespace App\Support;

use Composer\InstalledVersions;
use OutOfBoundsException;

/**
 * The release of JsonMapper that this site documents.
 *
 * Kept out of the prose so it cannot drift: the examples are analysed against
 * whatever `json-mapper/json-mapper` version is installed, so that same version
 * is what the pages actually describe. Bumping the dependency updates the site.
 */
final class DocumentedVersion
{
    public const PACKAGE = 'json-mapper/json-mapper';

    public static function get(): ?string
    {
        return self::fromInstalledPackages() ?? self::fromLockFile();
    }

    private static function fromInstalledPackages(): ?string
    {
        try {
            $version = InstalledVersions::getPrettyVersion(self::PACKAGE);
        } catch (OutOfBoundsException $exception) {
            // Not installed in this tree — see fromLockFile().
            return null;
        }

        return self::normalise($version);
    }

    /**
     * The deploy installs with --no-dev, and JsonMapper is only a dev dependency
     * (it exists to check the code examples, not to build pages). It is still
     * pinned in the lock file, which ships either way.
     */
    private static function fromLockFile(): ?string
    {
        $lock = dirname(__DIR__, 2) . '/composer.lock';

        if (! is_file($lock)) {
            return null;
        }

        $contents = json_decode((string) file_get_contents($lock), true);

        if (! is_array($contents)) {
            return null;
        }

        foreach (['packages', 'packages-dev'] as $section) {
            foreach ($contents[$section] ?? [] as $package) {
                if (($package['name'] ?? null) === self::PACKAGE) {
                    return self::normalise($package['version'] ?? null);
                }
            }
        }

        return null;
    }

    private static function normalise(?string $version): ?string
    {
        if ($version === null || $version === '') {
            return null;
        }

        // A branch alias such as "dev-develop" is not a release to point at.
        if (str_starts_with($version, 'dev-')) {
            return null;
        }

        return ltrim($version, 'v');
    }
}
