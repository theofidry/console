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
use Fidry\Console\Type\FloatType;
use const PHP_VERSION_ID;

/**
 * @covers \Fidry\Console\Type\FloatType
 */
final class FloatTypeTest extends BaseTypeTest
{
    protected function setUp(): void
    {
        $this->type = new FloatType();
    }

    public static function valueProvider(): iterable
    {
        yield [
            null,
            new TypeException('Expected a numeric. Got "NULL"'),
        ];

        yield [
            true,
            new TypeException('Expected a numeric. Got "true"'),
        ];

        yield '(string) integer' => [
            '10',
            10.,
        ];

        yield '(string) negative integer' => [
            '-10',
            -10.,
        ];

        yield '(string) float' => [
            '9.1',
            9.1,
        ];

        yield '(string) negative float' => [
            '-9.1',
            -9.1,
        ];

        yield 'string' => [
            'foo',
            new TypeException('Expected a numeric. Got "\'foo\'"'),
        ];

        if (PHP_VERSION_ID >= 80000) {
            yield 'integer with trailing space' => [
                '42 ',
                42.,
            ];
        } else {
            yield 'integer with trailing space' => [
                '42 ',
                new TypeException('Expected a numeric. Got "\'42 \'"'),
            ];
        }

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
