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

use Closure;
use Fidry\Console\Application\Application;
use Fidry\Console\Command\Command;
use function is_array;

final class ConfigurableCommandsApplication implements Application
{
    /**
     * @param Command[]|Closure(): Command[] $commandsFactory
     */
    public function __construct(
        private readonly Closure|array $commandsFactory
    ) {
    }

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
        if (is_array($this->commandsFactory)) {
            return $this->commandsFactory;
        }

        return ($this->commandsFactory)();
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
        return false;
    }
}
