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
use PHPUnit\Framework\Attributes\CoversClass;

#[CoversClass(StringChoiceType::class)]
final class StringChoiceTypeTest extends BaseTypeTestCase
{
    protected function setUp(): void
    {
        $this->type = new StringChoiceType(['foo', 'Bar']);
    }

    public static function valueProvider(): iterable
    {
        yield [
            null,
            new TypeException('Expected a string. Got "NULL" for the argument or option "test".'),
        ];

        yield [
            true,
            new TypeException('Expected a string. Got "true" for the argument or option "test".'),
        ];

        yield 'valid choice' => [
            'foo',
            'foo',
        ];

        yield 'invalid choice (different case)' => [
            'FOO',
            new TypeException('Expected one of: "foo", "Bar". Got: "FOO" for the argument or option "test".'),
        ];
    }
}
