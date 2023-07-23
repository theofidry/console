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

namespace Fidry\Console\Tests\IO;

use Fidry\Console\IO;
use PHPUnit\Framework\Assert;
use Symfony\Component\Console\Exception\InvalidArgumentException as ConsoleInvalidArgumentException;
use function sprintf;

final class TypeAssertions
{
    private function __construct()
    {
    }

    /**
     * @param non-empty-string $argumentName
     */
    public static function assertExpectedArgumentTypes(
        TypedInput $expected,
        IO $io,
        string $argumentName
    ): void {
        self::assertExpectedType(
            $expected->boolean,
            static fn () => $io->getTypedArgument($argumentName)->asBoolean(),
        );
        self::assertExpectedType(
            $expected->nullableBoolean,
            static fn () => $io->getTypedArgument($argumentName)->asNullableBoolean(),
        );
        self::assertExpectedType(
            $expected->string,
            static fn () => $io->getTypedArgument($argumentName)->asString(),
        );
        self::assertExpectedType(
            $expected->nullableString,
            static fn () => $io->getTypedArgument($argumentName)->asNullableString(),
        );
        self::assertExpectedType(
            $expected->stringArray,
            static fn () => $io->getTypedArgument($argumentName)->asStringList(),
        );
        self::assertExpectedType(
            $expected->integer,
            static fn () => $io->getTypedArgument($argumentName)->asNatural(),
        );
        self::assertExpectedType(
            $expected->nullableInteger,
            static fn () => $io->getTypedArgument($argumentName)->asNullableNatural(),
        );
        self::assertExpectedType(
            $expected->integerArray,
            static fn () => $io->getTypedArgument($argumentName)->asNaturalList(),
        );
        self::assertExpectedType(
            $expected->float,
            static fn () => $io->getTypedArgument($argumentName)->asFloat(),
        );
        self::assertExpectedType(
            $expected->nullableFloat,
            static fn () => $io->getTypedArgument($argumentName)->asNullableFloat(),
        );
        self::assertExpectedType(
            $expected->floatArray,
            static fn () => $io->getTypedArgument($argumentName)->asFloatList(),
        );
    }

    /**
     * @param non-empty-string $optionName
     */
    public static function assertExpectedOptionTypes(
        TypedInput $expected,
        IO $io,
        string $optionName
    ): void {
        self::assertExpectedType(
            $expected->boolean,
            static fn () => $io->getTypedOption($optionName)->asBoolean(),
        );
        self::assertExpectedType(
            $expected->nullableBoolean,
            static fn () => $io->getTypedOption($optionName)->asNullableBoolean(),
        );
        self::assertExpectedType(
            $expected->string,
            static fn () => $io->getTypedOption($optionName)->asString(),
        );
        self::assertExpectedType(
            $expected->nullableString,
            static fn () => $io->getTypedOption($optionName)->asNullableString(),
        );
        self::assertExpectedType(
            $expected->stringArray,
            static fn () => $io->getTypedOption($optionName)->asStringList(),
        );
        self::assertExpectedType(
            $expected->integer,
            static fn () => $io->getTypedOption($optionName)->asNatural(),
        );
        self::assertExpectedType(
            $expected->nullableInteger,
            static fn () => $io->getTypedOption($optionName)->asNullableNatural(),
        );
        self::assertExpectedType(
            $expected->integerArray,
            static fn () => $io->getTypedOption($optionName)->asNaturalList(),
        );
        self::assertExpectedType(
            $expected->float,
            static fn () => $io->getTypedOption($optionName)->asFloat(),
        );
        self::assertExpectedType(
            $expected->nullableFloat,
            static fn () => $io->getTypedOption($optionName)->asNullableFloat(),
        );
        self::assertExpectedType(
            $expected->floatArray,
            static fn () => $io->getTypedOption($optionName)->asFloatList(),
        );
    }

    /**
     * @param mixed|TypeException $expected
     * @param callable():mixed    $getArgument
     */
    private static function assertExpectedType($expected, callable $getArgument): void
    {
        try {
            $actual = $getArgument();

            if ($expected instanceof TypeException) {
                Assert::fail(
                    sprintf(
                        'Expected a type exception to be thrown with the message "%s"',
                        $expected->message,
                    ),
                );
            }
        } catch (ConsoleInvalidArgumentException $exception) {
            if ($expected instanceof TypeException) {
                Assert::assertSame(
                    $expected->message,
                    $exception->getMessage(),
                );

                return;
            }

            throw $exception;
        }

        Assert::assertSame($expected, $actual);
    }
}
