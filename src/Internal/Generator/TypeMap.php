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

namespace Fidry\Console\Internal\Generator;

use Fidry\Console\Internal\Type\BooleanType;
use Fidry\Console\Internal\Type\FloatType;
use Fidry\Console\Internal\Type\ListType;
use Fidry\Console\Internal\Type\NaturalType;
use Fidry\Console\Internal\Type\NullableType;
use Fidry\Console\Internal\Type\StringType;

/**
 * @private
 */
final class TypeMap
{
    private function __construct()
    {
    }

    public static function provideTypes(): array
    {
        // TODO: this will be heavily refactored later
        return [
            new BooleanType(),
            new NullableType(new BooleanType()),

            new StringType(),
            new NullableType(new StringType()),
            new ListType(new StringType()),

            new NaturalType(),
            new NullableType(new NaturalType()),
            new ListType(new NaturalType()),

            new FloatType(),
            new NullableType(new FloatType()),
            new ListType(new FloatType()),
        ];
    }
}
