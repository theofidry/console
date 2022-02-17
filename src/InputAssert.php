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

namespace Fidry\Console;

use function array_is_list;
use Fidry\Console\Input\InvalidInputValueType;
use function get_debug_type;
use function is_array;
use function is_bool;
use function is_string;
use function Safe\sprintf;
use function var_export;
use Webmozart\Assert\Assert;
use Webmozart\Assert\InvalidArgumentException as AssertInvalidArgumentException;

/**
 * @private
 * @psalm-type ArgumentInput = null|string|list<string>
 * @psalm-type OptionInput = null|bool|string|list<string>
 */
final class InputAssert
{
    private function __construct()
    {
    }

    /**
     * @param mixed $argument
     *
     * @psalm-assert ArgumentInput $argument
     */
    public static function assertIsValidArgumentType($argument): void
    {
        if (null === $argument || is_string($argument)) {
            return;
        }

        if (!is_array($argument) || !array_is_list($argument)) {
            throw new InvalidInputValueType(
                sprintf(
                    'Expected an argument value type to be "null|string|list<string>". Got "%s"',
                    get_debug_type($argument),
                ),
            );
        }

        foreach ($argument as $item) {
            self::assertIsValidArgumentType($item);
        }
    }

    /**
     * @param mixed $option
     *
     * @psalm-assert OptionInput $option
     */
    public static function assertIsValidOptionType($option): void
    {
        if (null === $option || is_bool($option) || is_string($option)) {
            return;
        }

        if (!is_array($option) || !array_is_list($option)) {
            throw new InvalidInputValueType(
                sprintf(
                    'Expected an option value type to be "null|bool|string|list<string>". Got "%s"',
                    get_debug_type($option),
                ),
            );
        }

        foreach ($option as $item) {
            self::assertIsValidOptionType($item);
        }
    }

    /**
     * @param ArgumentInput|OptionInput $value
     *
     * @psalm-assert scalar|null $value
     */
    public static function assertIsScalar($value): void
    {
        self::castThrowException(
            static function () use ($value): void {
                if (null === $value) {
                    return;
                }

                Assert::scalar(
                    $value,
                    sprintf(
                        'Expected a null or scalar value. Got the value: "%s"',
                        self::castType($value),
                    ),
                );
            },
        );
    }

    /**
     * @param ArgumentInput|OptionInput $value
     *
     * @psalm-assert list $value
     */
    public static function assertIsList($value): void
    {
        self::castThrowException(
            static function () use ($value): void {
                Assert::isArray(
                    $value,
                    sprintf(
                        'Cannot cast a non-array input argument into an array. Got "%s"',
                        self::castType($value),
                    ),
                );
                /** @psalm-suppress RedundantConditionGivenDocblockType */
                Assert::isList(
                    $value,
                    sprintf(
                        'Expected array to be a list. Got "%s"',
                        self::castType($value),
                    ),
                );
            },
        );
    }

    /**
     * @param ArgumentInput|OptionInput $value
     *
     * @psalm-assert numeric $value
     */
    public static function numericString($value): void
    {
        self::castThrowException(
            static function () use ($value): void {
                self::assertIsScalar($value);
                Assert::string(
                    $value,
                    sprintf(
                        'Expected a numeric string. Got "%s"',
                        self::castType($value),
                    ),
                );
                Assert::numeric(
                    $value,
                    sprintf(
                        'Expected a numeric string. Got "%s"',
                        self::castType($value),
                    ),
                );
            },
        );
    }

    /**
     * @param ArgumentInput|OptionInput $value
     *
     * @psalm-assert string $value
     */
    public static function integerString($value): void
    {
        self::castThrowException(
            static function () use ($value): void {
                self::assertIsScalar($value);
                Assert::string(
                    $value,
                    sprintf(
                        'Expected an integer string. Got "%s"',
                        self::castType($value),
                    ),
                );
                Assert::digits(
                    $value,
                    sprintf(
                        'Expected an integer string. Got "%s"',
                        self::castType($value),
                    ),
                );
            },
        );
    }

    /**
     * @param ArgumentInput|OptionInput $value
     *
     * @psalm-assert string $value
     */
    public static function string($value): void
    {
        self::castThrowException(
            static function () use ($value): void {
                self::assertIsScalar($value);
                Assert::string(
                    $value,
                    sprintf(
                        'Expected a string. Got "%s"',
                        self::castType($value),
                    ),
                );
            },
        );
    }

    /**
     * @param callable(): void $callable
     */
    private static function castThrowException(callable $callable): void
    {
        try {
            $callable();
        } catch (AssertInvalidArgumentException $exception) {
            throw InvalidInputValueType::fromAssert($exception);
        }
    }

    /**
     * @param ArgumentInput|OptionInput $value
     */
    private static function castType($value): string
    {
        return var_export($value, true);
    }
}
