<?php

declare(strict_types=1);

namespace Fidry\Console\Tests\Generator;

use Fidry\Console\Generator\GetterGenerator;
use Fidry\Console\Generator\GetterNameGenerator;
use Fidry\Console\Generator\ParameterType;
use Fidry\Console\Generator\Type\BooleanType;
use Fidry\Console\Generator\Type\InputType;
use Fidry\Console\Generator\Type\ListType;
use Fidry\Console\Generator\Type\NullableType;
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
            $option = $this->getOption($name);
        
            $type = TypeFactory::createTypeFromClassNames(
                'Fidry\Console\Generator\Type\BooleanType',
            );
        
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
                $argument = $this->getArgument($name);
            
                $type = TypeFactory::createTypeFromClassNames(
                    'Fidry\Console\Generator\Type\BooleanType',
                );
            
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
                $argument = $this->getArgument($name);
            
                $type = TypeFactory::createTypeFromClassNames(
                    'Fidry\Console\Generator\Type\NullableType',
                    'Fidry\Console\Generator\Type\BooleanType',
                );
            
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
                $argument = $this->getArgument($name);
            
                $type = TypeFactory::createTypeFromClassNames(
                    'Fidry\Console\Generator\Type\ListType',
                    'Fidry\Console\Generator\Type\BooleanType',
                );
            
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
                $argument = $this->getArgument($name);
            
                $type = TypeFactory::createTypeFromClassNames(
                    'Fidry\Console\Generator\Type\NullableType',
                    'Fidry\Console\Generator\Type\ListType',
                    'Fidry\Console\Generator\Type\BooleanType',
                );
            
                return $type->castValue($argument);
            }
            PHP,
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
