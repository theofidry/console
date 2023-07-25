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

use Fidry\Console\Internal\Type\PositiveIntegerType;
use Fidry\Console\Tests\IO\TypeException;
use PHPUnit\Framework\Attributes\CoversClass;

#[CoversClass(PositiveIntegerType::class)]
final class PositiveIntegerTypeTest extends BaseTypeTestCase
{
    protected function setUp(): void
    {
        $this->type = new PositiveIntegerType();
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

        yield '(string) integer' => [
            '10',
            10,
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
