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
use Fidry\Console\Output\Compatibility\StyledOutputSymfony5;
use Fidry\Console\Output\Compatibility\StyledOutputSymfony6;
use function Safe\class_alias;
use function version_compare;

// This is purely for the compatibility layer between Symfony5 & Symfony6. The
// behaviour is the same, only the method signatures differ.
// To have a more comprehensive look of the class check:
// stubs/StyledOutput.php
class_alias(
    (string) version_compare(
        (string) InstalledVersions::getPrettyVersion('symfony/console'),
        'v6.0',
        '>=',
    )
        ? StyledOutputSymfony6::class
        : StyledOutputSymfony5::class,
    \Fidry\Console\Output\StyledOutput::class,
);
