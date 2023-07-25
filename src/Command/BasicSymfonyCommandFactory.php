<?php

declare(strict_types=1);

namespace Fidry\Console\Command;

use Fidry\Console\Command\Command as FidryCommand;
use Fidry\Console\Command\LazyCommand as FidryLazyCommand;
use Symfony\Component\Console\Command\Command as BaseSymfonyCommand;
use Symfony\Component\Console\Command\LazyCommand as SymfonyLazyCommand;

final class BasicSymfonyCommandFactory implements SymfonyCommandFactory
{
    public function crateSymfonyCommand(Command $command): BaseSymfonyCommand
    {
        return $command instanceof FidryLazyCommand
            ? new SymfonyLazyCommand(
                $command::getName(),
                [],
                $command::getDescription(),
                false,
                static fn() => new SymfonyCommand($command),
                true,
            )
            : new SymfonyCommand($command);
    }
}