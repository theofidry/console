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

use Fidry\Console\Internal\Type\BackedEnumType;
use Fidry\Console\Tests\Enum\BackedIntegerEnum;
use Fidry\Console\Tests\IO\TypeException;
use PHPUnit\Framework\Attributes\CoversClass;

#[CoversClass(BackedEnumType::class)]
final class BackedIntegerBackedEnumTypeTest extends BaseTypeTestCase
{
    protected function setUp(): void
    {
        $this->type = new BackedEnumType(BackedIntegerEnum::class);
    }

    public static function valueProvider(): iterable
    {
        yield 'valid enum value' => [
            '10',
            BackedIntegerEnum::A,
        ];

        yield 'invalid enum value' => [
            '12',
            new TypeException(
                <<<'TXT'
                    Expected a value "Fidry\Console\Tests\Enum\BackedIntegerEnum" enum. Got "'12'" for the argument or option "test".
                    TXT,
            ),
        ];

        yield 'invalid type value' => [
            true,
            new TypeException(
                <<<'TXT'
                    Expected a value "Fidry\Console\Tests\Enum\BackedIntegerEnum" enum. Got "true" for the argument or option "test".
                    TXT,
            ),
        ];

        yield 'null value' => [
            null,
            new TypeException(
                <<<'TXT'
                    Expected a value "Fidry\Console\Tests\Enum\BackedIntegerEnum" enum. Got "NULL" for the argument or option "test".
                    TXT,
            ),
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
