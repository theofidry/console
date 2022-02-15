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

use Fidry\Console\Type\IntegerType;
use Fidry\Console\Type\NullableType;

/**
 * @covers \Fidry\Console\Type\NullableType
 */
final class NullableTypeTest extends BaseTypeTest
{
    protected function setUp(): void
    {
        $this->type = new NullableType(new IntegerType());
    }

    /**
     * @dataProvider validTypeProvider
     *
     * @param null|bool|string|list<string> $value
     */
    public function test_it_properly_infers_the_type($value): void
    {
        $value = $this->type->castValue($value);

        $this->assertCastedTypeIsCorrectlyInferred($value);
    }

    public function test_it_exposes_its_type_and_inner_type(): void
    {
        $expected = [
            NullableType::class,
            IntegerType::class,
        ];

        $actual = $this->type->getTypeClassNames();

        self::assertSame($expected, $actual);
    }

    public static function valueProvider(): iterable
    {
        yield 'integer value' => [
            '10',
            10,
        ];

        yield 'empty integer value' => [
            '0',
            0,
        ];

        yield 'null value' => [
            null,
            null,
        ];
    }

    public static function validTypeProvider(): iterable
    {
        yield from self::valueProvider();
    }

    private function assertCastedTypeIsCorrectlyInferred(?int $_value): void
    {
        /** @psalm-suppress InternalMethod */
        $this->addToAssertionCount(1);
    }
}
