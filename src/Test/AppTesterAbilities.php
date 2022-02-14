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

use Fidry\Console\DisplayNormalizer;
use Symfony\Component\Console\Tester\ApplicationTester;

/**
 * @psalm-require-implements \Fidry\Console\Test\AppTesterTestCase
 * @psalm-require-extends \PHPUnit\Framework\TestCase
 */
trait AppTesterAbilities
{
    private ApplicationTester $appTester;

    public function getAppTester(): ApplicationTester
    {
        return $this->appTester;
    }

    /**
     * @param null|callable(string):string $extraNormalization
     */
    private function assertExpectedOutput(
        string $expectedOutput,
        int $expectedStatusCode,
        ?callable $extraNormalization = null
    ): void {
        $appTester = $this->getAppTester();

        $actual = $this->getNormalizeDisplay(
            $appTester->getDisplay(true),
            $extraNormalization,
        );

        self::assertSame($expectedOutput, $actual);
        self::assertSame($expectedStatusCode, $appTester->getStatusCode());
    }

    private function getNormalizeDisplay(
        string $display,
        ?callable $extraNormalization = null
    ): string {
        $extraNormalization = $extraNormalization ?? static fn (string $display) => $display;

        $display = DisplayNormalizer::removeTrailingSpaces($display);

        return $extraNormalization($display);
    }
}
