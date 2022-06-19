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

namespace Fidry\Console\Tests;

use Fidry\Console\DisplayNormalizer;
use PHPUnit\Framework\TestCase;
use function sprintf;

/**
 * @covers \Fidry\Console\DisplayNormalizer
 */
final class DisplayNormalizerTest extends TestCase
{
    /**
     * @dataProvider displayProvider
     */
    public function test_it_normalizes_the_given_output(string $value, string $expected): void
    {
        $actual = DisplayNormalizer::removeTrailingSpaces($value);

        self::assertSame($expected, $actual);
    }

    public function test_it_normalizes_the_given_output_and_apply_the_given_extra_normalizers(): void
    {
        $value = ' foo ';

        $extraNormalizer1 = static fn (string $value): string => sprintf('extraNormalizer1(%s)', $value);
        $extraNormalizer2 = static fn (string $value): string => sprintf('extraNormalizer2(%s)', $value);

        $expected = 'extraNormalizer2(extraNormalizer1( foo))';

        $actual = DisplayNormalizer::removeTrailingSpaces(
            $value,
            $extraNormalizer1,
            $extraNormalizer2,
        );

        self::assertSame($expected, $actual);
    }

    public static function displayProvider(): iterable
    {
        yield 'empty string' => [
            '',
            '',
        ];

        yield 'blank string' => [
            ' ',
            '',
        ];

        yield 'string with leading and trailing spaces' => [
            ' foo ',
            ' foo',
        ];

        yield 'empty line returns' => [
            <<<'EOT'
            
             
            EOT,
            <<<'EOT'
            
            
            EOT,
        ];

        yield 'windows line returns' => [
            "\n\r",
            <<<'EOT'
            
            
            EOT,
        ];

        yield 'line returns with leading and trailing spaces' => [
            <<<'EOT'
             foo 
            bar  
            EOT,
            <<<'EOT'
             foo
            bar
            EOT,
        ];
    }
}
