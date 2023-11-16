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

use Fidry\Console\Application\BaseApplication;
use Fidry\Console\Bridge\Command\ReversedSymfonyCommand;
use Fidry\Console\Tests\Command\Fixture\SimpleSymfonyCommand;

final class ApplicationWithReversedCommand extends BaseApplication
{
    public function getCommands(): array
    {
        return [
            new ReversedSymfonyCommand(
                new SimpleSymfonyCommand(),
            ),
        ];
    }

    public function getName(): string
    {
        return 'ApplicationWithReversedCommand';
    }

    public function getVersion(): string
    {
        return '0.0';
    }

    public function isAutoExitEnabled(): bool
    {
        return false;
    }
}
