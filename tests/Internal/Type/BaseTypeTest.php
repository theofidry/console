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

namespace Fidry\Console\Tests\Internal\Type;

use Fidry\Console\Internal\Type\InputType;
use Fidry\Console\Tests\IO\TypeException;
use PHPUnit\Framework\Assert;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Console\Exception\InvalidArgumentException as ConsoleInvalidArgumentException;
use function sprintf;

abstract class BaseTypeTest extends TestCase
{
    protected InputType $type;

    /**
     * @dataProvider valueProvider
     *
     * @param null|bool|string|list<string> $value
     * @param bool|TypeException            $expected
     */
    final public function test_it_can_cast_values($value, $expected): void
    {
        try {
            $actual = $this->type->coerceValue($value, 'the argument or option "test"');

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
                self::assertSame(
                    $expected->message,
                    $exception->getMessage(),
                );

                return;
            }

            throw $exception;
        }

        self::assertSame($expected, $actual);
    }

    abstract public static function valueProvider(): iterable;
}
