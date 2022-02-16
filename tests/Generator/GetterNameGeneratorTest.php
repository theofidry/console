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

namespace Fidry\Console\Tests\Generator;

use Fidry\Console\Generator\GetterNameGenerator;
use Fidry\Console\Generator\ParameterType;
use Fidry\Console\Type\BooleanType;
use Fidry\Console\Type\InputType;
use Fidry\Console\Type\ListType;
use Fidry\Console\Type\NullableType;
use PHPUnit\Framework\TestCase;

/**
 * @covers \Fidry\Console\Generator\GetterNameGenerator
 */
final class GetterNameGeneratorTest extends TestCase
{
    /**
     * @dataProvider typeProvider
     */
    public function test_it_can_generate_name(InputType $type, string $expected): void
    {
        $actual = GetterNameGenerator::generateMethodName(
            ParameterType::ARGUMENT,
            $type->getTypeClassNames(),
        );

        self::assertSame($expected, $actual);
    }

    public static function typeProvider(): iterable
    {
        yield 'singular type' => [
            new BooleanType(),
            'getBooleanArgument',
        ];

        yield 'composed type' => [
            new NullableType(
                new BooleanType(),
            ),
            'getNullableBooleanArgument',
        ];

        yield 'deep composed type' => [
            new NullableType(
                new ListType(
                    new BooleanType(),
                ),
            ),
            'getNullableBooleanListArgument',
        ];
    }
}
