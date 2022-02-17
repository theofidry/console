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

use Fidry\Console\Internal\Generator\GetterGenerator;
use Fidry\Console\Internal\Type\BooleanType;
use Fidry\Console\Internal\Type\InputType;
use Fidry\Console\Internal\Type\ListType;
use Fidry\Console\Internal\Type\NullableType;
use PHPUnit\Framework\TestCase;

/**
 * @covers \Fidry\Console\Internal\Generator\GetterGenerator
 */
final class GetterGeneratorTest extends TestCase
{
    /**
     * @dataProvider typeProvider
     */
    public function test_it_can_generate_a_getter_for_an_argument(InputType $type, string $expected): void
    {
        $actual = GetterGenerator::generate($type);

        self::assertSame($expected, $actual);
    }

    public static function typeProvider(): iterable
    {
        yield 'singular type' => [
            new BooleanType(),
            <<<'PHP'
            /**
             * @return bool
             */
            public function asBoolean(): bool
            {
                $type = TypeFactory::createTypeFromClassNames([
                    \Fidry\Console\Internal\Type\BooleanType::class,
                ]);
            
                return $type->castValue($this->value);
            }
            PHP,
        ];

        yield 'nullable singular type' => [
            new NullableType(
                new BooleanType(),
            ),
            <<<'PHP'
            /**
             * @return null|bool
             */
            public function asNullableBoolean(): ?bool
            {
                $type = TypeFactory::createTypeFromClassNames([
                    \Fidry\Console\Internal\Type\NullableType::class,
                    \Fidry\Console\Internal\Type\BooleanType::class,
                ]);
            
                return $type->castValue($this->value);
            }
            PHP,
        ];

        yield 'list of singular type' => [
            new ListType(
                new BooleanType(),
            ),
            <<<'PHP'
            /**
             * @return list<bool>
             */
            public function asBooleanList(): array
            {
                $type = TypeFactory::createTypeFromClassNames([
                    \Fidry\Console\Internal\Type\ListType::class,
                    \Fidry\Console\Internal\Type\BooleanType::class,
                ]);
            
                return $type->castValue($this->value);
            }
            PHP,
        ];

        yield 'nullable list of singular type' => [
            new NullableType(
                new ListType(
                    new BooleanType(),
                ),
            ),
            <<<'PHP'
            /**
             * @return null|list<bool>
             */
            public function asNullableBooleanList(): ?array
            {
                $type = TypeFactory::createTypeFromClassNames([
                    \Fidry\Console\Internal\Type\NullableType::class,
                    \Fidry\Console\Internal\Type\ListType::class,
                    \Fidry\Console\Internal\Type\BooleanType::class,
                ]);
            
                return $type->castValue($this->value);
            }
            PHP,
        ];

        yield 'list of nullable singular type' => [
            new ListType(
                new NullableType(
                    new BooleanType(),
                ),
            ),
            <<<'PHP'
            /**
             * @return list<null|bool>
             */
            public function asNullableBooleanList(): array
            {
                $type = TypeFactory::createTypeFromClassNames([
                    \Fidry\Console\Internal\Type\ListType::class,
                    \Fidry\Console\Internal\Type\NullableType::class,
                    \Fidry\Console\Internal\Type\BooleanType::class,
                ]);
            
                return $type->castValue($this->value);
            }
            PHP,
        ];
    }
}
