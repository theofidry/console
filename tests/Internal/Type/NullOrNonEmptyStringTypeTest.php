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

use Fidry\Console\Internal\Type\NullOrNonEmptyStringType;
use Fidry\Console\Tests\IO\TypeException;
use PHPUnit\Framework\Attributes\CoversClass;

#[CoversClass(NullOrNonEmptyStringType::class)]
final class NullOrNonEmptyStringTypeTest extends BaseTypeTestCase
{
    protected function setUp(): void
    {
        $this->type = new NullOrNonEmptyStringType();
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
            'foo',
        ];

        foreach ($stringValues as $stringValue) {
            yield [$stringValue, $stringValue];
        }

        yield 'empty string' => [
            '',
            null,
        ];

        yield 'blank string' => [
            ' ',
            null,
        ];

        yield 'string with spaces' => [
            ' foo ',
            'foo',
        ];

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
