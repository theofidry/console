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

/**
 * @covers \Fidry\Console\Type\IntegerType
 */
final class IntegerTypeTest extends BaseTypeTest
{
    protected function setUp(): void
    {
        $this->type = new IntegerType();
    }

    public static function valueProvider(): iterable
    {
        yield [
            null,
            new TypeException('Expected an integer string. Got "NULL"'),
        ];

        yield [
            true,
            new TypeException('Expected an integer string. Got "true"'),
        ];

        yield '(string) integer' => [
            '10',
            10,
        ];

        yield '(string) negative integer' => [
            '-10',
            new TypeException('Expected an integer. Got "\'-10\'"'),
        ];

        yield '(string) float' => [
            '9.1',
            new TypeException('Expected an integer. Got "\'9.1\'"'),
        ];

        yield 'string' => [
            'foo',
            new TypeException('Expected an integer. Got "\'foo\'"'),
        ];

        yield 'integer with trailing space' => [
            '42 ',
            new TypeException('Expected an integer. Got "\'42 \'"'),
        ];

        yield [
            [],
            new TypeException(
                <<<'TXT'
                Cannot cast an array input argument as a scalar. Got the argument value: "array (
                )"
                TXT,
            ),
        ];
    }
}
