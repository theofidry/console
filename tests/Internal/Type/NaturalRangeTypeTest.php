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

use Fidry\Console\Internal\Type\NaturalRangeType;
use Fidry\Console\Tests\IO\TypeException;

/**
 * @covers \Fidry\Console\Internal\Type\NaturalRangeType
 *
 * @internal
 */
final class NaturalRangeTypeTest extends BaseTypeTest
{
    protected function setUp(): void
    {
        $this->type = new NaturalRangeType(2, 5);
    }

    public static function valueProvider(): iterable
    {
        yield [
            null,
            new TypeException('Expected an integer string. Got "NULL" for the argument or option "test".'),
        ];

        yield [
            true,
            new TypeException('Expected an integer string. Got "true" for the argument or option "test".'),
        ];

        yield '(string) integer outside of bound (min)' => [
            '1',
            new TypeException('Expected a value between 2 and 5. Got: 1 for the argument or option "test".'),
        ];

        yield '(string) integer at limit (min)' => [
            '2',
            2,
        ];

        yield '(string) integer within bounds' => [
            '3',
            3,
        ];

        yield '(string) integer within at limit (max)' => [
            '5',
            5,
        ];

        yield '(string) integer outside of bound (max)' => [
            '6',
            new TypeException('Expected a value between 2 and 5. Got: 6 for the argument or option "test".'),
        ];

        yield '(string) negative integer' => [
            '-10',
            new TypeException('Expected an integer string. Got "\'-10\'" for the argument or option "test".'),
        ];

        yield '(string) float' => [
            '9.1',
            new TypeException('Expected an integer string. Got "\'9.1\'" for the argument or option "test".'),
        ];

        yield 'string' => [
            'foo',
            new TypeException('Expected an integer string. Got "\'foo\'" for the argument or option "test".'),
        ];

        yield 'integer with trailing space' => [
            '42 ',
            new TypeException('Expected an integer string. Got "\'42 \'" for the argument or option "test".'),
        ];

        yield [
            [],
            new TypeException(
                <<<'TXT'
                    Expected a null or scalar value. Got the value: "array (
                    )" for the argument or option "test".
                    TXT,
            ),
        ];
    }
}
