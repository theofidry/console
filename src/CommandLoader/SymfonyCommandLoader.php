<?php

declare(strict_types=1);

namespace Fidry\Console\CommandLoader;

use Fidry\Console\Command\SymfonyCommandFactory;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\CommandLoader\CommandLoaderInterface;

final class SymfonyCommandLoader implements CommandLoaderInterface
{
    public function __construct(
        private readonly CommandLoader $commandLoader,
        private readonly SymfonyCommandFactory $symfonyCommandFactory,
    ) {
    }

    public function get(string $name): Command
    {
        return $this->symfonyCommandFactory->crateSymfonyCommand(
            $this->commandLoader->get($name),
        );
    }

    public function has(string $name): bool
    {
        return $this->commandLoader->has($name);
    }

    public function getNames(): array
    {
        return $this->commandLoader->getNames();
    }
}