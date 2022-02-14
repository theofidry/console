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

namespace Fidry\Console\Command;

use function array_is_list;
use function get_debug_type;
use function is_array;
use function is_bool;
use function is_string;
use function Safe\sprintf;
use Symfony\Component\Console\Exception\InvalidArgumentException as ConsoleInvalidArgumentException;
use function var_export;
use Webmozart\Assert\Assert;
use Webmozart\Assert\InvalidArgumentException as AssertInvalidArgumentException;

/**
 * @private
 * @psalm-type ArgumentInput = null|string|string[]
 * @psalm-type OptionInput = null|bool|string|list<string>
 */
final class ConsoleAssert
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

        if (!is_array($argument)) {
            throw new ConsoleInvalidArgumentException(
                sprintf(
                    'Expected an argument value type to be "null|string|string[]". Got "%s"',
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
            throw new ConsoleInvalidArgumentException(
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
     * @psalm-assert !array $value
     */
    public static function assertIsNotArray($value): void
    {
        /** @psalm-suppress MissingClosureReturnType */
        self::castThrowException(
            static fn () => Assert::false(
                is_array($value),
                sprintf(
                    'Cannot cast an array input argument as a scalar. Got the argument value: "%s"',
                    self::castType($value),
                ),
            ),
        );
    }

    /**
     * @param ArgumentInput|OptionInput $value
     *
     * @psalm-assert list $value
     */
    public static function assertIsList($value): void
    {
        /** @psalm-suppress MissingClosureReturnType */
        self::castThrowException(
            static fn () => Assert::isList(
                $value,
                sprintf(
                    'Cannot cast a non-array input argument into an array. Got the value "%s"',
                    self::castType($value),
                ),
            ),
        );
    }

    /**
     * @param ArgumentInput|OptionInput $value
     *
     * @psalm-assert numeric $value
     */
    public static function numeric($value): void
    {
        /** @psalm-suppress MissingClosureReturnType */
        self::castThrowException(
            static fn () => Assert::numeric(
                $value,
                sprintf(
                    'Expected a numeric. Got "%s"',
                    self::castType($value),
                ),
            ),
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
                self::assertIsNotArray($value);
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
                        'Expected an integer. Got "%s"',
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
            throw new ConsoleInvalidArgumentException(
                $exception->getMessage(),
                (int) $exception->getCode(),
                $exception,
            );
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
