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

use Fidry\Console\Internal\Type\InputType;
use Fidry\Console\Internal\Type\IntegerType;
use Fidry\Console\Internal\Type\ListType;
use Fidry\Console\Internal\Type\NullableType;

/**
 * @covers \Fidry\Console\Internal\Type\NullableType
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

    /**
     * @dataProvider nullableProvider
     *
     * @param list<class-string<InputType>> $expected
     */
    public function test_it_exposes_its_type_and_inner_type(NullableType $input, array $expected): void
    {
        $actual = $input->getTypeClassNames();

        self::assertSame($expected, $actual);
    }

    /**
     * @dataProvider nullableProvider
     *
     * @param mixed $_
     */
    public function test_it_exposes_its_psalm_declaration(NullableType $input, $_, string $expected): void
    {
        $actual = $input->getPsalmTypeDeclaration();

        self::assertSame($expected, $actual);
    }

    /**
     * @dataProvider nullableProvider
     *
     * @param mixed $_1
     * @param mixed $_2
     */
    public function test_it_exposes_its_php_declaration(NullableType $input, $_1, $_2, string $expected): void
    {
        $actual = $input->getPhpTypeDeclaration();

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

    public static function nullableProvider(): iterable
    {
        yield 'scalar type' => [
            new NullableType(new IntegerType()),
            [
                NullableType::class,
                IntegerType::class,
            ],
            'null|int',
            '?int',
        ];

        yield 'composed type' => [
            new NullableType(new ListType(new IntegerType())),
            [
                NullableType::class,
                ListType::class,
                IntegerType::class,
            ],
            'null|list<int>',
            '?array',
        ];
    }

    private function assertCastedTypeIsCorrectlyInferred(?int $_value): void
    {
        /** @psalm-suppress InternalMethod */
        $this->addToAssertionCount(1);
    }
}
