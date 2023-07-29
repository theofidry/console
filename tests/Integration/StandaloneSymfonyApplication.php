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

namespace Fidry\Console\Tests\Integration;

use DomainException;
use Fidry\Console\Application\BaseApplication;
use Fidry\Console\Helper\QuestionHelper;
use Fidry\Console\Tests\Application\Fixture\ManualLazyCommand;
use Fidry\Console\Tests\Command\Fixture\CommandAwareCommand;
use Fidry\Console\Tests\Command\Fixture\CommandWithArgumentAndOption;
use Fidry\Console\Tests\Command\Fixture\CommandWithHelpers;
use Fidry\Console\Tests\Command\Fixture\CommandWithService;
use Fidry\Console\Tests\Command\Fixture\FakeCommand;
use Fidry\Console\Tests\Command\Fixture\FullLifeCycleCommand;
use Fidry\Console\Tests\Command\Fixture\SimpleCommand;
use Fidry\Console\Tests\Command\Fixture\SimpleLazyCommand;
use Fidry\Console\Tests\StatefulService;
use Symfony\Component\Console\Helper\DebugFormatterHelper;
use Symfony\Component\Console\Helper\DescriptorHelper;
use Symfony\Component\Console\Helper\FormatterHelper;
use Symfony\Component\Console\Helper\ProcessHelper;

final class StandaloneSymfonyApplication extends BaseApplication
{
    public function getName(): string
    {
        return 'Standalone App';
    }

    public function getVersion(): string
    {
        return '1.0.0';
    }

    public function getCommands(): array
    {
        return [
            new SimpleCommand(),
            new FullLifeCycleCommand(
                new QuestionHelper(),
            ),
            new CommandWithHelpers(
                new DebugFormatterHelper(),
                new DescriptorHelper(),
                new FormatterHelper(),
                new ProcessHelper(),
                new QuestionHelper(),
            ),
            new CommandAwareCommand(),
            new CommandWithArgumentAndOption(),
            new CommandWithService(
                new StatefulService(),
            ),
            new ManualLazyCommand(
                static fn () => new FakeCommand(),
            ),
            // TODO: add easier support for lazy commands in order to allow this.
            // new SimpleLazyCommand(static fn () => throw new DomainException()),
        ];
    }
}
