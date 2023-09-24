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
use Fidry\Console\Tests\Enum\BackedStringEnum;
use Fidry\Console\Tests\IO\TypeException;
use PHPUnit\Framework\Attributes\CoversClass;

#[CoversClass(BackedEnumType::class)]
final class BackedStringBackedEnumTypeTest extends BaseTypeTestCase
{
    protected function setUp(): void
    {
        $this->type = new BackedEnumType(BackedStringEnum::class);
    }

    public static function valueProvider(): iterable
    {
        yield 'valid enum value' => [
            'alpha',
            BackedStringEnum::A,
        ];

        yield 'invalid enum value' => [
            'unknown',
            new TypeException(
                <<<'TXT'
                    Expected a value "Fidry\Console\Tests\Enum\BackedStringEnum" enum. Got "'unknown'" for the argument or option "test".
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
