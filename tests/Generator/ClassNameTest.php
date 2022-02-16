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

use Closure;
use Fidry\Console\Generator\ClassName;
use PHPUnit\Framework\TestCase;

/**
 * @covers \Fidry\Console\Generator\ClassName
 */
final class ClassNameTest extends TestCase
{
    /**
     * @dataProvider classNameProvider
     *
     * @param class-string $className
     */
    public function test_it_can_get_a_class_short_name(
        string $className,
        string $expectedShortName
    ): void {
        $actual = ClassName::getShortClassName($className);

        self::assertSame($expectedShortName, $actual);
    }

    public static function classNameProvider(): iterable
    {
        yield 'nominal' => [
            ClassName::class,
            'ClassName',
        ];

        yield 'UTF-8' => [
            Ütf8::class,
            'Ütf8',
        ];

        yield 'emoji' => [
            Special😋Class::class,
            'Special😋Class',
        ];

        yield 'root namespace' => [
            Closure::class,
            'Closure',
        ];
    }
}
