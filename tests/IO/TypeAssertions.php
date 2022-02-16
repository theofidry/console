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

use Fidry\Console\Input\IO;
use PHPUnit\Framework\Assert;
use function Safe\sprintf;
use Symfony\Component\Console\Exception\InvalidArgumentException as ConsoleInvalidArgumentException;

final class TypeAssertions
{
    private function __construct()
    {
    }

    public static function assertExpectedArgumentTypes(
        TypedInput $expected,
        IO $io,
        string $argumentName
    ): void {
        self::assertExpectedType(
            $expected->boolean,
            static fn () => $io->getArgument($argumentName)->asBoolean(),
        );
        self::assertExpectedType(
            $expected->nullableBoolean,
            static fn () => $io->getArgument($argumentName)->asNullableBoolean(),
        );
        self::assertExpectedType(
            $expected->string,
            static fn () => $io->getArgument($argumentName)->asString(),
        );
        self::assertExpectedType(
            $expected->nullableString,
            static fn () => $io->getArgument($argumentName)->asNullableString(),
        );
        self::assertExpectedType(
            $expected->stringArray,
            static fn () => $io->getArgument($argumentName)->asStringList(),
        );
        self::assertExpectedType(
            $expected->integer,
            static fn () => $io->getArgument($argumentName)->asInteger(),
        );
        self::assertExpectedType(
            $expected->nullableInteger,
            static fn () => $io->getArgument($argumentName)->asNullableInteger(),
        );
        self::assertExpectedType(
            $expected->integerArray,
            static fn () => $io->getArgument($argumentName)->asIntegerList(),
        );
        self::assertExpectedType(
            $expected->float,
            static fn () => $io->getArgument($argumentName)->asFloat(),
        );
        self::assertExpectedType(
            $expected->nullableFloat,
            static fn () => $io->getArgument($argumentName)->asNullableFloat(),
        );
        self::assertExpectedType(
            $expected->floatArray,
            static fn () => $io->getArgument($argumentName)->asFloatList(),
        );
    }

    public static function assertExpectedOptionTypes(
        TypedInput $expected,
        IO $io,
        string $optionName
    ): void {
        self::assertExpectedType(
            $expected->boolean,
            static fn () => $io->getOption($optionName)->asBoolean(),
        );
        self::assertExpectedType(
            $expected->nullableBoolean,
            static fn () => $io->getOption($optionName)->asNullableBoolean(),
        );
        self::assertExpectedType(
            $expected->string,
            static fn () => $io->getOption($optionName)->asString(),
        );
        self::assertExpectedType(
            $expected->nullableString,
            static fn () => $io->getOption($optionName)->asNullableString(),
        );
        self::assertExpectedType(
            $expected->stringArray,
            static fn () => $io->getOption($optionName)->asStringList(),
        );
        self::assertExpectedType(
            $expected->integer,
            static fn () => $io->getOption($optionName)->asInteger(),
        );
        self::assertExpectedType(
            $expected->nullableInteger,
            static fn () => $io->getOption($optionName)->asNullableInteger(),
        );
        self::assertExpectedType(
            $expected->integerArray,
            static fn () => $io->getOption($optionName)->asIntegerList(),
        );
        self::assertExpectedType(
            $expected->float,
            static fn () => $io->getOption($optionName)->asFloat(),
        );
        self::assertExpectedType(
            $expected->nullableFloat,
            static fn () => $io->getOption($optionName)->asNullableFloat(),
        );
        self::assertExpectedType(
            $expected->floatArray,
            static fn () => $io->getOption($optionName)->asFloatList(),
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
