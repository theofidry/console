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

use Fidry\Console\Internal\Generator\GetterNameGenerator;
use Fidry\Console\Internal\Type\BooleanType;
use Fidry\Console\Internal\Type\InputType;
use Fidry\Console\Internal\Type\ListType;
use Fidry\Console\Internal\Type\NullableType;
use PHPUnit\Framework\TestCase;

/**
 * @covers \Fidry\Console\Internal\Generator\GetterNameGenerator
 */
final class GetterNameGeneratorTest extends TestCase
{
    /**
     * @dataProvider typeProvider
     */
    public function test_it_can_generate_name(InputType $type, string $expected): void
    {
        $actual = GetterNameGenerator::generateMethodName(
            $type->getTypeClassNames(),
        );

        self::assertSame($expected, $actual);
    }

    public static function typeProvider(): iterable
    {
        yield 'singular type' => [
            new BooleanType(),
            'asBoolean',
        ];

        yield 'composed type' => [
            new NullableType(
                new BooleanType(),
            ),
            'asNullableBoolean',
        ];

        yield 'deep composed type' => [
            new NullableType(
                new ListType(
                    new BooleanType(),
                ),
            ),
            'asNullableBooleanList',
        ];
    }
}
