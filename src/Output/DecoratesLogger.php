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

namespace Fidry\Console\Output;

use Composer\InstalledVersions;
use Fidry\Console\Output\Compatibility\DecoratesLoggerPsr1;
use Fidry\Console\Output\Compatibility\DecoratesLoggerPsr2;
use function Safe\class_alias;
use function version_compare;

// This is purely for the compatibility layer between Symfony5 & Symfony6. The
// behaviour is the same, only the method signatures differ.
// To have a more comprehensive look of the class check:
// stubs/DecoratesInput.php
class_alias(
    (string) version_compare(
        (string) InstalledVersions::getPrettyVersion('psr/log'),
        '2.0.0',
        '>=',
    )
        ? DecoratesLoggerPsr2::class
        : DecoratesLoggerPsr1::class,
    \Fidry\Console\Output\DecoratesLogger::class,
);
