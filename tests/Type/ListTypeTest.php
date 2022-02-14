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

namespace Fidry\Console\Tests\Type;

use Fidry\Console\Tests\IO\TypeException;
use Fidry\Console\Type\IntegerType;
use Fidry\Console\Type\ListType;

/**
 * @covers \Fidry\Console\Type\ListType
 */
final class ListTypeTest extends BaseTypeTest
{
    protected function setUp(): void
    {
        $this->type = new ListType(new IntegerType());
    }

    public static function valueProvider(): iterable
    {
        yield 'integer value' => [
            '10',
            new TypeException('Cannot cast a non-array input argument into an array. Got the value "\'10\'"'),
        ];

        yield 'empty array' => [
            [],
            [],
        ];

        yield 'array with integers' => [
            ['10', '0'],
            [10, 0],
        ];

        yield 'array with non-integers' => [
            ['10', 'foo'],
            new TypeException('Expected an integer. Got "\'foo\'"'),
        ];
    }
}
