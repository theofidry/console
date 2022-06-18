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

    /**
     * @param null|callable(string):string $extraNormalizers
     */
    public static function assertSameOutput(
        string $expectedOutput,
        int $expectedStatusCode,
        // TODO: add support for Symfony App & CommandTester
        AppTester|CommandTester $actual,
        callable ...$extraNormalizers
    ): void {
        $actualOutput = $actual->getNormalizedDisplay(...$extraNormalizers);

        Assert::assertSame($expectedOutput, $actualOutput);
        Assert::assertSame($expectedStatusCode, $actual->getStatusCode());
    }
}
