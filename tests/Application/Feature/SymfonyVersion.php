<?php

/*
 * This file is part of the Fidry\Console package.
 *
 * (c) Théo FIDRY <theo.fidry@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Fidry\Console\Tests\Application\Feature;

use Composer\InstalledVersions;
use Composer\Semver\VersionParser;

final class SymfonyVersion
{
    private function __construct()
    {
    }

    public static function isSfConsole72OrHigher(): bool
    {
        return InstalledVersions::satisfies(
            new VersionParser(),
            'symfony/console',
            '^7.2',
        );
    }
}
