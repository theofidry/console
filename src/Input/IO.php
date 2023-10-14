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

use function class_alias;
use function sprintf;
use function trigger_deprecation;

$alias = \Fidry\Console\Input\IO::class;
$newClass = \Fidry\Console\IO::class;

@trigger_deprecation(
    'fidry/console',
    '0.6.0',
    sprintf(
        'Using the class "%s" is deprecated. Use "%s" instead.',
        $alias,
        $newClass,
    ),
);

class_alias($newClass, $alias);
