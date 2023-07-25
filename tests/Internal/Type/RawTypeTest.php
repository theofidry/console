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

use Fidry\Console\Internal\Type\RawType;
use PHPUnit\Framework\Attributes\CoversClass;

#[CoversClass(RawType::class)]
final class RawTypeTest extends BaseTypeTestCase
{
    protected function setUp(): void
    {
        $this->type = new RawType();
    }

    public static function valueProvider(): iterable
    {
        $values = [
            null,
            true,
            '10',
            '0',
            '.5',
            '',
            ' ',
            'foo',
            [],
            ['foo', 'bar '],
        ];

        foreach ($values as $value) {
            yield [$value, $value];
        }
    }
}
