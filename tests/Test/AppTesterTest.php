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

namespace Fidry\Console\Tests\Test;

use Fidry\Console\ExitCode;
use Fidry\Console\Test\AppTester;
use Fidry\Console\Test\OutputAssertions;
use Fidry\Console\Tests\Test\Fixture\Application;
use PHPUnit\Framework\TestCase;
use function str_replace;

/**
 * @covers \Fidry\Console\Test\AppTester
 * @covers \Fidry\Console\Test\OutputAssertions
 */
final class AppTesterTest extends TestCase
{
    private AppTester $appTester;

    protected function setUp(): void
    {
        $this->appTester = AppTester::fromConsoleApp(
            new Application(),
        );
    }

    public function test_it_can_assert_the_output_via_the_app_tester(): void
    {
        $this->appTester->run(['app:path']);

        OutputAssertions::assertSameOutput(
            <<<'EOT'

            The project path is /home/runner/work/console/console.
            
            EOT,
            ExitCode::SUCCESS,
            $this->appTester,
        );
    }

    public function test_it_can_assert_the_output_with_custom_normalization_via_the_app_tester(): void
    {
        $this->appTester->run(['app:path']);

        $extraNormalization = static fn (string $display): string => str_replace(
            '/home/runner/work/console/console',
            '/path/to/console',
            $display,
        );

        OutputAssertions::assertSameOutput(
            <<<'EOT'

            The project path is /path/to/console.

            EOT,
            ExitCode::SUCCESS,
            $this->appTester,
            $extraNormalization,
        );
    }
}
