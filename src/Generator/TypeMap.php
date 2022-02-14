<?php

declare(strict_types=1);

namespace Fidry\Console\Generator;

use Fidry\Console\Generator\Type\BooleanType;
use Fidry\Console\Generator\Type\FloatType;
use Fidry\Console\Generator\Type\IntegerType;
use Fidry\Console\Generator\Type\ListType;
use Fidry\Console\Generator\Type\NullableType;
use Fidry\Console\Generator\Type\StringType;

final class TypeMap
{
    public function provideMap(): array
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
