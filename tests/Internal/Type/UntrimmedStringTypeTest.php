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
use PHPUnit\Framework\Attributes\CoversClass;

#[CoversClass(UntrimmedStringType::class)]
final class UntrimmedStringTypeTest extends BaseTypeTestCase
{
    protected function setUp(): void
    {
        $this->type = new UntrimmedStringType();
    }

    public static function valueProvider(): iterable
    {
        yield [
            null,
            new TypeException('Expected a string. Got "NULL" for the argument or option "test".'),
        ];

        yield [
            true,
            new TypeException('Expected a string. Got "true" for the argument or option "test".'),
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
                    )" for the argument or option "test".
                    TXT,
            ),
        ];
    }
}
