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

namespace Fidry\Console\Tests\Type;

use Fidry\Console\Tests\IO\TypeException;
use Fidry\Console\Type\BooleanType;

/**
 * @covers \Fidry\Console\Type\BooleanType
 */
final class BooleanTypeTest extends BaseTypeTest
{
    protected function setUp(): void
    {
        $this->type = new BooleanType();
    }

    public static function valueProvider(): iterable
    {
        $trueishValues = [
            true,
            '1',
            ' ',
            '0 ',
            'null',
        ];

        $falseishValues = [
            null,
            false,
            '0',
        ];

        foreach ($trueishValues as $trueishValue) {
            yield [$trueishValue, true];
        }

        foreach ($falseishValues as $falseishValue) {
            yield [$falseishValue, false];
        }

        yield [
            [],
            new TypeException(
                <<<'TXT'
                Cannot cast an array input argument as a scalar. Got the argument value: "array (
                )"
                TXT,
            ),
        ];
    }
}
