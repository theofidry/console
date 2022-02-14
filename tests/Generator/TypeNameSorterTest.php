<?php

declare(strict_types=1);

namespace Fidry\Console\Tests\Generator;

use Fidry\Console\Generator\Type\BooleanType;
use Fidry\Console\Generator\Type\InputType;
use Fidry\Console\Generator\Type\ListType;
use Fidry\Console\Generator\Type\NullableType;
use Fidry\Console\Generator\Type\StringType;
use Fidry\Console\Generator\TypeNameCollector;
use Fidry\Console\Generator\TypeNameSorter;
use PHPUnit\Framework\TestCase;

/**
 * @covers \Fidry\Console\Generator\TypeNameSorter
 */
final class TypeNameSorterTest extends TestCase
{
    /**
     * @dataProvider typeProvider
     *
     * @param list<class-string<InputType>> $typeClassNames
     * @param list<class-string<InputType>> $expected
     */
    public function test_it_can_collect_types(array $typeClassNames, array $expected): void
    {
        $actual = TypeNameSorter::sortClassNames($typeClassNames);

        self::assertSame($expected, $actual);
    }

    public static function typeProvider(): iterable
    {
        yield 'singular type' => [
            [BooleanType::class],
            [BooleanType::class],
        ];

        yield 'composed type' => [
            [
                NullableType::class,
                BooleanType::class,
            ],
            [
                NullableType::class,
                BooleanType::class,
            ],
        ];

        yield 'list type' => [
            [
                ListType::class,
                BooleanType::class,
            ],
            [
                BooleanType::class,
                ListType::class,
            ],
        ];

        yield 'nullable list type' => [
            [
                NullableType::class,
                ListType::class,
                BooleanType::class,
            ],
            [
                NullableType::class,
                BooleanType::class,
                ListType::class,
            ],
        ];

        yield 'list nullable type' => [
            [
                ListType::class,
                NullableType::class,
                BooleanType::class,
            ],
            [
                NullableType::class,
                BooleanType::class,
                ListType::class,
            ],
        ];

        // This case is more to capture the behaviour as in practice we never
        // have nested lists
        yield 'nested list type' => [
            [
                BooleanType::class,
                ListType::class,
                NullableType::class,
                ListType::class,
                StringType::class,
            ],
            [
                BooleanType::class,
                NullableType::class,
                StringType::class,
                ListType::class,
                ListType::class,
            ],
        ];
    }
}
