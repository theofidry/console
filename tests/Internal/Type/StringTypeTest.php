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

use Fidry\Console\Internal\Type\StringType;
use Fidry\Console\Tests\IO\TypeException;
use PHPUnit\Framework\Attributes\CoversClass;

#[CoversClass(StringType::class)]
final class StringTypeTest extends BaseTypeTestCase
{
    protected function setUp(): void
    {
        $this->type = new StringType();
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
            'foo',
        ];

        foreach ($stringValues as $stringValue) {
            yield [$stringValue, $stringValue];
        }

        yield 'blank string' => [
            ' ',
            '',
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
