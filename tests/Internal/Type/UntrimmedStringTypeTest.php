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

use Fidry\Console\Internal\Type\UntrimmedStringType;
use Fidry\Console\Tests\IO\TypeException;

/**
 * @covers \Fidry\Console\Internal\Type\UntrimmedStringType
 */
final class UntrimmedStringTypeTest extends BaseTypeTest
{
    protected function setUp(): void
    {
        $this->type = new UntrimmedStringType();
    }

    public static function valueProvider(): iterable
    {
        yield [
            null,
            new TypeException('Expected a string. Got "NULL"'),
        ];

        yield [
            true,
            new TypeException('Expected a string. Got "true"'),
        ];

        $stringValues = [
            '10',
            '9.1',
            'null',
            '',
            ' ',
            'foo',
        ];

        foreach ($stringValues as $stringValue) {
            yield [$stringValue, $stringValue];
        }

        yield [
            [],
            new TypeException(
                <<<'TXT'
                Expected a null or scalar value. Got the value: "array (
                )"
                TXT,
            ),
        ];
    }
}
