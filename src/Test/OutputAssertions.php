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

namespace Fidry\Console\Test;

use PHPUnit\Framework\Assert;

final class OutputAssertions
{
    private function __construct()
    {
    }

    public static function assertSameOutput(
        string $expectedOutput,
        int $expectedStatusCode,
        AppTester $actual,
        ?callable $extraNormalization = null
    ): void {
        $actualOutput = $actual->getNormalizedDisplay($extraNormalization);

        Assert::assertSame($expectedOutput, $actualOutput);
        Assert::assertSame($expectedStatusCode, $actual->getStatusCode());
    }
}
