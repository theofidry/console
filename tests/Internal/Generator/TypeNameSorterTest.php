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

namespace Fidry\Console\Tests\Internal\Generator;

use Fidry\Console\Internal\Generator\TypeNameSorter;
use Fidry\Console\Internal\Type\BooleanType;
use Fidry\Console\Internal\Type\InputType;
use Fidry\Console\Internal\Type\ListType;
use Fidry\Console\Internal\Type\NonEmptyListType;
use Fidry\Console\Internal\Type\NullableType;
use Fidry\Console\Internal\Type\StringType;
use PHPUnit\Framework\TestCase;

/**
 * @covers \Fidry\Console\Internal\Generator\TypeNameSorter
 *
 * @internal
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

        yield 'non-empty-list type' => [
            [
                NonEmptyListType::class,
                BooleanType::class,
            ],
            [
                BooleanType::class,
                NonEmptyListType::class,
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
