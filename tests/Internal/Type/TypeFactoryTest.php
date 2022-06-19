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

use Fidry\Console\Internal\Type\BooleanType;
use Fidry\Console\Internal\Type\InputType;
use Fidry\Console\Internal\Type\ListType;
use Fidry\Console\Internal\Type\NullableType;
use Fidry\Console\Internal\Type\TypeFactory;
use PHPUnit\Framework\TestCase;

/**
 * @covers \Fidry\Console\Internal\Type\TypeFactory
 */
final class TypeFactoryTest extends TestCase
{
    /**
     * @dataProvider typeProvider
     */
    public function test_it_can_cast_value(InputType $type): void
    {
        $expected = $type;

        $actual = TypeFactory::createTypeFromClassNames(
            $type->getTypeClassNames(),
        );

        self::assertEquals($expected, $actual);
    }

    public static function typeProvider(): iterable
    {
        yield 'singular type' => [
            new BooleanType(),
        ];

        yield 'nullable singular type' => [
            new NullableType(
                new BooleanType(),
            ),
        ];

        yield 'list of singular type' => [
            new ListType(
                new BooleanType(),
            ),
        ];

        yield 'nullable list of singular type' => [
            new NullableType(
                new ListType(
                    new BooleanType(),
                ),
            ),
        ];

        yield 'list of nullable singular type' => [
            new ListType(
                new NullableType(
                    new BooleanType(),
                ),
            ),
        ];
    }
}
