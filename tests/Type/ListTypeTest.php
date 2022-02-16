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
use Fidry\Console\Type\InputType;
use Fidry\Console\Type\IntegerType;
use Fidry\Console\Type\ListType;
use Fidry\Console\Type\NullableType;

/**
 * @covers \Fidry\Console\Type\ListType
 */
final class ListTypeTest extends BaseTypeTest
{
    protected function setUp(): void
    {
        $this->type = new ListType(new IntegerType());
    }

    /**
     * @dataProvider listProvider
     *
     * @param list<class-string<InputType>> $expected
     */
    public function test_it_exposes_its_type_and_inner_type(ListType $input, array $expected): void
    {
        $actual = $input->getTypeClassNames();

        self::assertSame($expected, $actual);
    }

    /**
     * @dataProvider listProvider
     *
     * @param mixed $_
     */
    public function test_it_exposes_its_psalm_declaration(ListType $input, $_, string $expected): void
    {
        $actual = $input->getPsalmTypeDeclaration();

        self::assertSame($expected, $actual);
    }

    public static function valueProvider(): iterable
    {
        yield 'integer value' => [
            '10',
            new TypeException('Cannot cast a non-array input argument into an array. Got "\'10\'"'),
        ];

        yield 'empty array' => [
            [],
            [],
        ];

        yield 'array with integers' => [
            ['10', '0'],
            [10, 0],
        ];

        yield 'array with non-integers' => [
            ['10', 'foo'],
            new TypeException('Expected an integer string. Got "\'foo\'"'),
        ];
    }

    public static function listProvider(): iterable
    {
        yield 'scalar type' => [
            new ListType(new IntegerType()),
            [
                ListType::class,
                IntegerType::class,
            ],
            'list<int>',
        ];

        yield 'composed type' => [
            new ListType(new NullableType(new IntegerType())),
            [
                ListType::class,
                NullableType::class,
                IntegerType::class,
            ],
            'list<null|int>',
        ];
    }
}
