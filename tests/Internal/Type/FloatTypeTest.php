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

namespace Fidry\Console\Tests\Internal\Type;

use Fidry\Console\Internal\Type\FloatType;
use Fidry\Console\Tests\IO\TypeException;
use const PHP_VERSION_ID;

/**
 * @covers \Fidry\Console\Internal\Type\FloatType
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
            new TypeException('Expected a numeric string. Got "NULL"'),
        ];

        yield [
            true,
            new TypeException('Expected a numeric string. Got "true"'),
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
            new TypeException('Expected a numeric string. Got "\'foo\'"'),
        ];

        if (PHP_VERSION_ID >= 80000) {
            yield 'integer with trailing space' => [
                '42 ',
                42.,
            ];
        } else {
            yield 'integer with trailing space' => [
                '42 ',
                new TypeException('Expected a numeric string. Got "\'42 \'"'),
            ];
        }

        yield [
            [],
            new TypeException(
                <<<'TXT'
                Expected a null or scalar value. Got the value: "array (
                )"
                TXT,
            ),
        ];
    }
}
