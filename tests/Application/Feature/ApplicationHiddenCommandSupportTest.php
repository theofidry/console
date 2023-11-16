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

namespace Fidry\Console\Tests\Application\Feature;

use Fidry\Console\Application\Application;
use Fidry\Console\Application\ApplicationRunner;
use Fidry\Console\Bridge\Application\SymfonyApplication;
use Fidry\Console\Bridge\Command\SymfonyCommand;
use Fidry\Console\Tests\Application\Fixture\ConfigurableCommandsApplication;
use Fidry\Console\Tests\Application\OutputAssertions;
use Fidry\Console\Tests\Command\Fixture\HiddenCommand;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Console\Input\StringInput;
use Symfony\Component\Console\Output\BufferedOutput;

#[CoversClass(ApplicationRunner::class)]
#[CoversClass(SymfonyApplication::class)]
#[CoversClass(SymfonyCommand::class)]
final class ApplicationHiddenCommandSupportTest extends TestCase
{
    public function test_it_can_show_the_list_of_the_available_commands(): void
    {
        $input = new StringInput('list');
        $output = new BufferedOutput();

        ApplicationRunner::runApplication(
            self::createApplication(),
            $input,
            $output,
        );

        $actual = $output->fetch();
        $expected = <<<'EOT'
            help message

            Usage:
              command [options] [arguments]

            Options:
              -h, --help            Display help for the given command. When no command is given display help for the app:foo command
              -q, --quiet           Do not output any message
              -V, --version         Display this application version
                  --ansi|--no-ansi  Force (or disable --no-ansi) ANSI output
              -n, --no-interaction  Do not ask any interactive question
              -v|vv|vvv, --verbose  Increase the verbosity of messages: 1 for normal output, 2 for more verbose output and 3 for debug

            Available commands:
              completion  Dump the shell completion script
              help        Display help for a command
              list        List commands

            EOT;

        OutputAssertions::assertSameOutput(
            $expected,
            $actual,
        );
    }

    public function test_it_can_execute_the_hidden_command(): void
    {
        $input = new StringInput('app:hidden');
        $output = new BufferedOutput();

        ApplicationRunner::runApplication(
            self::createApplication(),
            $input,
            $output,
        );

        $actual = $output->fetch();

        OutputAssertions::assertSameOutput(
            <<<'EOF'
                OK

                EOF,
            $actual,
        );
    }

    private static function createApplication(): Application
    {
        return new ConfigurableCommandsApplication([
            new HiddenCommand(),
        ]);
    }
}
