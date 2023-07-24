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

use Fidry\Console\Internal\Type\BooleanType;
use Fidry\Console\Tests\IO\TypeException;
use PHPUnit\Framework\Attributes\CoversClass;

#[CoversClass(BooleanType::class)]
final class BooleanTypeTestCase extends BaseTypeTestCase
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
                    Expected a null or scalar value. Got the value: "array (
                    )" for the argument or option "test".
                    TXT,
            ),
        ];
    }
}
