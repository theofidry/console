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

use Fidry\Console\Internal\Generator\GettersGenerator;
use Fidry\Console\Internal\Type\BooleanType;
use Fidry\Console\Internal\Type\InputType;
use Fidry\Console\Internal\Type\StringType;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

#[CoversClass(GettersGenerator::class)]
final class GettersGeneratorTest extends TestCase
{
    /**
     * @param non-empty-list<InputType> $types
     */
    #[DataProvider('typesProvider')]
    public function test_it_can_generate_getters_for_the_given_types_and_parameters(
        array $types,
        string $expected
    ): void {
        $actual = GettersGenerator::generate($types);

        self::assertSame($expected, $actual);
    }

    public static function typesProvider(): iterable
    {
        yield 'nominal' => [
            [new StringType(), new BooleanType()],
            <<<'PHP'

                    public function asString(?string $errorMessage = null): string
                    {
                        $type = TypeFactory::createTypeFromClassNames([
                            \Fidry\Console\Internal\Type\StringType::class,
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
    }
}
