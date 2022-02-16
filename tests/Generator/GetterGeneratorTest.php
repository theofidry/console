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

use Fidry\Console\Generator\GetterGenerator;
use Fidry\Console\Generator\ParameterType;
use Fidry\Console\Type\BooleanType;
use Fidry\Console\Type\InputType;
use Fidry\Console\Type\ListType;
use Fidry\Console\Type\NullableType;
use PHPUnit\Framework\TestCase;

/**
 * @covers \Fidry\Console\Generator\GetterGenerator
 */
final class GetterGeneratorTest extends TestCase
{
    /**
     * @dataProvider typeProvider
     */
    public function test_it_can_generate_a_getter_for_an_argument(InputType $type, string $expected): void
    {
        $actual = GetterGenerator::generate(
            ParameterType::ARGUMENT,
            $type,
        );

        self::assertSame($expected, $actual);
    }

    public function test_it_can_generate_a_getter_for_an_option(): void
    {
        $type = new BooleanType();
        $expected = <<<'PHP'
        /**
         * @return bool
         */
        public function getBooleanOption(string $name): bool
        {
            $option = $this->getLegacyOption($name);
        
            $type = TypeFactory::createTypeFromClassNames([
                \Fidry\Console\Type\BooleanType::class,
            ]);
        
            return $type->castValue($option);
        }
        PHP;

        $actual = GetterGenerator::generate(
            ParameterType::OPTION,
            $type,
        );

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
            public function getBooleanArgument(string $name): bool
            {
                $argument = $this->getLegacyArgument($name);
            
                $type = TypeFactory::createTypeFromClassNames([
                    \Fidry\Console\Type\BooleanType::class,
                ]);
            
                return $type->castValue($argument);
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
            public function getNullableBooleanArgument(string $name): ?bool
            {
                $argument = $this->getLegacyArgument($name);
            
                $type = TypeFactory::createTypeFromClassNames([
                    \Fidry\Console\Type\NullableType::class,
                    \Fidry\Console\Type\BooleanType::class,
                ]);
            
                return $type->castValue($argument);
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
            public function getBooleanListArgument(string $name): array
            {
                $argument = $this->getLegacyArgument($name);
            
                $type = TypeFactory::createTypeFromClassNames([
                    \Fidry\Console\Type\ListType::class,
                    \Fidry\Console\Type\BooleanType::class,
                ]);
            
                return $type->castValue($argument);
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
            public function getNullableBooleanListArgument(string $name): ?array
            {
                $argument = $this->getLegacyArgument($name);
            
                $type = TypeFactory::createTypeFromClassNames([
                    \Fidry\Console\Type\NullableType::class,
                    \Fidry\Console\Type\ListType::class,
                    \Fidry\Console\Type\BooleanType::class,
                ]);
            
                return $type->castValue($argument);
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
            public function getNullableBooleanListArgument(string $name): array
            {
                $argument = $this->getLegacyArgument($name);
            
                $type = TypeFactory::createTypeFromClassNames([
                    \Fidry\Console\Type\ListType::class,
                    \Fidry\Console\Type\NullableType::class,
                    \Fidry\Console\Type\BooleanType::class,
                ]);
            
                return $type->castValue($argument);
            }
            PHP,
        ];
    }
}
