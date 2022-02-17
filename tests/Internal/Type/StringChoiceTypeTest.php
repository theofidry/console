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

use Fidry\Console\Internal\Type\StringChoiceType;
use Fidry\Console\Tests\IO\TypeException;

/**
 * @covers \Fidry\Console\Internal\Type\StringChoiceType
 */
final class StringChoiceTypeTest extends BaseTypeTest
{
    protected function setUp(): void
    {
        $this->type = new StringChoiceType(['foo', 'Bar']);
    }

    public static function valueProvider(): iterable
    {
        yield [
            null,
            new TypeException('Expected a string. Got "NULL"'),
        ];

        yield [
            true,
            new TypeException('Expected a string. Got "true"'),
        ];

        yield 'valid choice' => [
            'foo',
            'foo',
        ];

        yield 'invalid choice (different case)' => [
            'FOO',
            new TypeException('Expected one of: "foo", "Bar". Got: "FOO"'),
        ];
    }
}
