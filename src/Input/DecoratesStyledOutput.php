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

namespace Fidry\Console\Input;

use Composer\InstalledVersions;
use function Safe\class_alias;
use function version_compare;

class_alias(
    (string) version_compare(
        (string) InstalledVersions::getPrettyVersion('symfony/console'),
        'v6.0',
        '>=',
    )
        ? DecoratesStyledOutputSymfony6::class
        : DecoratesStyledOutputSymfony5::class,
    \Fidry\Console\Input\DecoratesStyledOutput::class,
);
