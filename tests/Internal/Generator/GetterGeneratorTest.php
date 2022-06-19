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
use Fidry\Console\Tests\Internal\Type\ConfigurableType;
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
            
            public function asBoolean(?string $errorMessage = null): bool
            {
                $type = TypeFactory::createTypeFromClassNames([
                    \Fidry\Console\Internal\Type\BooleanType::class,
                ]);
            
                if (null === $errorMessage) {
                    return $type->coerceValue($this->value, $this->label);
                }

                try {
                    return $type->coerceValue($this->value, $this->label);
                } catch (InvalidInputValueType $coercingFailed) {
                    throw InvalidInputValueType::withErrorMessage(
                        $coercingFailed,
                        $errorMessage,
                    );
                }
            }
            PHP,
        ];

        yield 'nullable singular type' => [
            new NullableType(
                new BooleanType(),
            ),
            <<<'PHP'

            public function asNullableBoolean(?string $errorMessage = null): ?bool
            {
                $type = TypeFactory::createTypeFromClassNames([
                    \Fidry\Console\Internal\Type\NullableType::class,
                    \Fidry\Console\Internal\Type\BooleanType::class,
                ]);
            
                if (null === $errorMessage) {
                    return $type->coerceValue($this->value, $this->label);
                }

                try {
                    return $type->coerceValue($this->value, $this->label);
                } catch (InvalidInputValueType $coercingFailed) {
                    throw InvalidInputValueType::withErrorMessage(
                        $coercingFailed,
                        $errorMessage,
                    );
                }
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
            public function asBooleanList(?string $errorMessage = null): array
            {
                $type = TypeFactory::createTypeFromClassNames([
                    \Fidry\Console\Internal\Type\ListType::class,
                    \Fidry\Console\Internal\Type\BooleanType::class,
                ]);
            
                if (null === $errorMessage) {
                    return $type->coerceValue($this->value, $this->label);
                }

                try {
                    return $type->coerceValue($this->value, $this->label);
                } catch (InvalidInputValueType $coercingFailed) {
                    throw InvalidInputValueType::withErrorMessage(
                        $coercingFailed,
                        $errorMessage,
                    );
                }
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
            public function asNullableBooleanList(?string $errorMessage = null): ?array
            {
                $type = TypeFactory::createTypeFromClassNames([
                    \Fidry\Console\Internal\Type\NullableType::class,
                    \Fidry\Console\Internal\Type\ListType::class,
                    \Fidry\Console\Internal\Type\BooleanType::class,
                ]);
            
                if (null === $errorMessage) {
                    return $type->coerceValue($this->value, $this->label);
                }

                try {
                    return $type->coerceValue($this->value, $this->label);
                } catch (InvalidInputValueType $coercingFailed) {
                    throw InvalidInputValueType::withErrorMessage(
                        $coercingFailed,
                        $errorMessage,
                    );
                }
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
            public function asNullableBooleanList(?string $errorMessage = null): array
            {
                $type = TypeFactory::createTypeFromClassNames([
                    \Fidry\Console\Internal\Type\ListType::class,
                    \Fidry\Console\Internal\Type\NullableType::class,
                    \Fidry\Console\Internal\Type\BooleanType::class,
                ]);
            
                if (null === $errorMessage) {
                    return $type->coerceValue($this->value, $this->label);
                }

                try {
                    return $type->coerceValue($this->value, $this->label);
                } catch (InvalidInputValueType $coercingFailed) {
                    throw InvalidInputValueType::withErrorMessage(
                        $coercingFailed,
                        $errorMessage,
                    );
                }
            }
            PHP,
        ];

        yield 'typeless type' => [
            new ConfigurableType(
                'bool',
                null,
            ),
            <<<'PHP'
            /**
             * @return bool
             */
            public function asConfigurable(?string $errorMessage = null)
            {
                $type = TypeFactory::createTypeFromClassNames([
                    \Fidry\Console\Tests\Internal\Type\ConfigurableType::class,
                ]);
            
                if (null === $errorMessage) {
                    return $type->coerceValue($this->value, $this->label);
                }

                try {
                    return $type->coerceValue($this->value, $this->label);
                } catch (InvalidInputValueType $coercingFailed) {
                    throw InvalidInputValueType::withErrorMessage(
                        $coercingFailed,
                        $errorMessage,
                    );
                }
            }
            PHP,
        ];

        yield 'non native PHP type' => [
            new ConfigurableType(
                'int<0,1>',
                'int',
            ),
            <<<'PHP'
            /**
             * @return int<0,1>
             */
            public function asConfigurable(?string $errorMessage = null): int
            {
                $type = TypeFactory::createTypeFromClassNames([
                    \Fidry\Console\Tests\Internal\Type\ConfigurableType::class,
                ]);
            
                if (null === $errorMessage) {
                    return $type->coerceValue($this->value, $this->label);
                }

                try {
                    return $type->coerceValue($this->value, $this->label);
                } catch (InvalidInputValueType $coercingFailed) {
                    throw InvalidInputValueType::withErrorMessage(
                        $coercingFailed,
                        $errorMessage,
                    );
                }
            }
            PHP,
        ];

        yield 'Psalm has extra types' => [
            new ConfigurableType(
                'int|float',
                'int',
            ),
            <<<'PHP'
            /**
             * @return int|float
             */
            public function asConfigurable(?string $errorMessage = null): int
            {
                $type = TypeFactory::createTypeFromClassNames([
                    \Fidry\Console\Tests\Internal\Type\ConfigurableType::class,
                ]);
            
                if (null === $errorMessage) {
                    return $type->coerceValue($this->value, $this->label);
                }

                try {
                    return $type->coerceValue($this->value, $this->label);
                } catch (InvalidInputValueType $coercingFailed) {
                    throw InvalidInputValueType::withErrorMessage(
                        $coercingFailed,
                        $errorMessage,
                    );
                }
            }
            PHP,
        ];

        yield 'PHP has extra types' => [
            new ConfigurableType(
                'int',
                'int|float',
            ),
            <<<'PHP'
            /**
             * @return int
             */
            public function asConfigurable(?string $errorMessage = null): int|float
            {
                $type = TypeFactory::createTypeFromClassNames([
                    \Fidry\Console\Tests\Internal\Type\ConfigurableType::class,
                ]);
            
                if (null === $errorMessage) {
                    return $type->coerceValue($this->value, $this->label);
                }

                try {
                    return $type->coerceValue($this->value, $this->label);
                } catch (InvalidInputValueType $coercingFailed) {
                    throw InvalidInputValueType::withErrorMessage(
                        $coercingFailed,
                        $errorMessage,
                    );
                }
            }
            PHP,
        ];
    }
}
