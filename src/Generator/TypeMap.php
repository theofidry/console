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

namespace Fidry\Console\Generator;

use Fidry\Console\Type\BooleanType;
use Fidry\Console\Type\FloatType;
use Fidry\Console\Type\IntegerType;
use Fidry\Console\Type\ListType;
use Fidry\Console\Type\NullableType;
use Fidry\Console\Type\StringType;

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

            new IntegerType(),
            new NullableType(new IntegerType()),
            new ListType(new IntegerType()),

            new FloatType(),
            new NullableType(new FloatType()),
            new ListType(new FloatType()),
        ];
    }
}
