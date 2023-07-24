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
use Fidry\Console\Internal\Type\ListType;
use Fidry\Console\Internal\Type\NaturalType;
use Fidry\Console\Internal\Type\NullableType;
use Fidry\Console\Internal\Type\StringType;
use Fidry\Console\Tests\IO\TypeException;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;

#[CoversClass(ListType::class)]
final class ListTypeTestCase extends BaseTypeTestCase
{
    protected function setUp(): void
    {
        $this->type = new ListType(new NaturalType());
    }

    /**
     * @param list<class-string<InputType>> $expected
     */
    #[DataProvider('listProvider')]
    public function test_it_exposes_its_type_and_inner_type(InputType $input, array $expected): void
    {
        $actual = $input->getTypeClassNames();

        self::assertSame($expected, $actual);
    }

    /**
     * @param mixed $_
     */
    #[DataProvider('listProvider')]
    public function test_it_exposes_its_psalm_declaration(InputType $input, $_, string $expected): void
    {
        $actual = $input->getPsalmTypeDeclaration();

        self::assertSame($expected, $actual);
    }

    public static function valueProvider(): iterable
    {
        yield 'integer value' => [
            '10',
            new TypeException('Cannot cast a non-array input argument into an array. Got "\'10\'" for the argument or option "test".'),
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
            new TypeException('Expected an integer string. Got "\'foo\'" for the argument or option "test".'),
        ];
    }

    public static function listProvider(): iterable
    {
        yield 'scalar type' => [
            new ListType(new StringType()),
            [
                ListType::class,
                StringType::class,
            ],
            'list<string>',
        ];

        yield 'composed type' => [
            new ListType(new NullableType(new StringType())),
            [
                ListType::class,
                NullableType::class,
                StringType::class,
            ],
            'list<null|string>',
        ];
    }
}
