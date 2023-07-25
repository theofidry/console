<?php

declare(strict_types=1);

namespace Fidry\Console\CommandLoader;

use Fidry\Console\Command\Command;
use Symfony\Component\Console\Exception\CommandNotFoundException;

final class CompositeCommandLoader implements CommandLoader
{
    /**
     * @var list<CommandLoader>
     */
    private array $commandLoaders;

    public function __construct(CommandLoader ...$commandLoaders)
    {
        $this->commandLoaders = $commandLoaders;
    }

    public function get(string $name): Command
    {
        foreach ($this->commandLoaders as $commandLoader) {
            if ($commandLoader->has($name)) {
                return $commandLoader->get($name);
            }
        }

        throw new CommandNotFoundException(
            sprintf(
                'Command "%s" does not exist.',
                $name,
            ),
        );
    }

    public function has(string $name): bool
    {
        foreach ($this->commandLoaders as $commandLoader) {
            if ($commandLoader->has($name)) {
                return true;
            }
        }

        return false;
    }

    public function getNames(): array
    {
        return array_merge(
            ...array_map(
                static fn (CommandLoader $commandLoader) => $commandLoader->getNames(),
                $this->commandLoaders,
            ),
        );
    }
}