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

namespace Fidry\Console\Tests\Application\Fixture;

use Fidry\Console\Application\Application;
use Fidry\Console\Command\Command;
use Fidry\Console\Command\Configuration;
use Fidry\Console\Command\LazyCommand;
use Fidry\Console\Input\IO;
use Fidry\Console\Tests\Command\Fixture\FakeCommand;

final class ApplicationWithLazyCommands implements Application
{
    public function getName(): string
    {
        return 'AppWithLazyCommands';
    }

    public function getVersion(): string
    {
        return '1.0.0';
    }

    public function getLongVersion(): string
    {
        return '1.0.0@60a94d3e';
    }

    public function getCommands(): array
    {
        return [
            new class() implements LazyCommand {
                /** @psalm-suppress MissingConstructor */
                private Command $command;

                public static function getName(): string
                {
                    return 'app:lazy-foo';
                }

                public static function getDescription(): string
                {
                    return 'Lazy foo description';
                }

                public function getConfiguration(): Configuration
                {
                    return $this->getCommand()->getConfiguration();
                }

                public function execute(IO $io): int
                {
                    return $this->getCommand()->execute($io);
                }

                private function getCommand(): Command
                {
                    /** @psalm-suppress RedundantPropertyInitializationCheck */
                    if (!isset($this->command)) {
                        $this->command = new FakeCommand();
                    }

                    return $this->command;
                }
            },
        ];
    }

    public function isAutoExitEnabled(): bool
    {
        return false;
    }

    public function getHelp(): string
    {
        return 'help message';
    }

    public function getDefaultCommand(): string
    {
        return 'app:foo';
    }

    public function areExceptionsCaught(): bool
    {
        return true;
    }
}
