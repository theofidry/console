<?php

declare(strict_types=1);

namespace Fidry\Console\Tests\Type;

use Fidry\Console\Type\BooleanType;
use Fidry\Console\Type\InputType;
use Fidry\Console\Type\ListType;
use Fidry\Console\Type\NullableType;
use Fidry\Console\Type\TypeFactory;
use PHPUnit\Framework\TestCase;

/**
 * @covers \Fidry\Console\Type\TypeFactory
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

        // TODO: enable later
//        yield 'list of nullable singular type' => [
//            new ListType(
//                new NullableType(
//                    new BooleanType(),
//                ),
//            ),
//        ];
    }
}
