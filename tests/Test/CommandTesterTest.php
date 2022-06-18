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
use Fidry\Console\Test\CommandTester;
use Fidry\Console\Test\OutputAssertions;
use Fidry\Console\Tests\Command\Fixture\SimpleCommand;
use Fidry\Console\Tests\Test\Fixture\Application;
use Fidry\Console\Tests\Test\Fixture\PathCommand;
use PHPUnit\Framework\TestCase;
use function str_replace;

/**
 * @covers \Fidry\Console\Test\CommandTester
 * @covers \Fidry\Console\Test\OutputAssertions
 */
final class CommandTesterTest extends TestCase
{
    private CommandTester $commandTester;

    protected function setUp(): void
    {
        $this->commandTester = CommandTester::fromConsoleCommand(
            new PathCommand(),
        );
    }

    public function test_it_can_assert_the_output_via_the_app_tester(): void
    {
        $this->commandTester->execute([]);

        OutputAssertions::assertSameOutput(
            <<<'EOT'

            The project path is /home/runner/work/console/console.
            
            EOT,
            ExitCode::SUCCESS,
            $this->commandTester,
        );
    }

    public function test_it_can_assert_the_output_with_custom_normalization_via_the_app_tester(): void
    {
        $this->commandTester->execute([]);

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
            $this->commandTester,
            $extraNormalization,
        );
    }
}
