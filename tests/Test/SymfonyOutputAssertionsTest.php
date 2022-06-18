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

use Fidry\Console\Command\SymfonyCommand;
use Fidry\Console\ExitCode;
use Fidry\Console\Test\OutputAssertions;
use Fidry\Console\Tests\Test\Fixture\PathCommand;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Console\Application;
use Symfony\Component\Console\Tester\ApplicationTester;
use Symfony\Component\Console\Tester\CommandTester;

/**
 * @covers \Fidry\Console\Test\OutputAssertions
 */
final class SymfonyOutputAssertionsTest extends TestCase
{
    public function test_it_works_with_a_symfony_application_tester(): void
    {
        $app = new Application();
        $app->setAutoExit(false);
        $app->setCatchExceptions(false);
        $app->add(new SymfonyCommand(new PathCommand()));

        $appTester = new ApplicationTester($app);

        $appTester->run(['app:path']);

        OutputAssertions::assertSameOutput(
            <<<'EOT'

            The project path is /home/runner/work/console/console.

            EOT,
            ExitCode::SUCCESS,
            $appTester,
        );
    }

    public function test_it_works_with_a_symfony_command_tester(): void
    {
        $command = new SymfonyCommand(new PathCommand());

        $commandTester = new CommandTester($command);

        $commandTester->execute([]);

        OutputAssertions::assertSameOutput(
            <<<'EOT'

            The project path is /home/runner/work/console/console.
            
            EOT,
            ExitCode::SUCCESS,
            $commandTester,
        );
    }
}
