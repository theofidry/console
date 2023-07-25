<?php

declare(strict_types=1);

namespace Fidry\Console\CommandLoader;

use Fidry\Console\Command\Command;
use Fidry\Console\Command\LazyCommand;
use Symfony\Component\Console\CommandLoader\CommandLoaderInterface;
use Symfony\Component\Console\Exception\CommandNotFoundException;

final class FactoryCommandLoader implements CommandLoader
{
    /**
     * @param array<string, class-string<Command>|Command|callable():Command $factoriesOrCommandsIndexedByCommandNames
     */
    public function __construct(
        private readonly array $factoriesOrCommandsIndexedByCommandNames,
    ) {
    }

    public function has(string $name): bool
    {
        return array_key_exists($name, $this->factoriesOrCommandsIndexedByCommandNames);
    }

    public function get(string $name): Command
    {
        if (!$this->has($name)) {
            throw new CommandNotFoundException(
                sprintf(
                    'Command "%s" does not exist.',
                    $name,
                ),
            );
        }

        $factoryOrCommand = $this->factoriesOrCommandsIndexedByCommandNames[$name];

        if ($factoryOrCommand instanceof Command) {
            return $factoryOrCommand;
        }

        if (is_callable($factoryOrCommand)) {
            return $factoryOrCommand();
        }

        $implementedInterfaces = class_implements($factoryOrCommand);

        if (false !== $implementedInterfaces && in_array(LazyCommand::class, $implementedInterfaces, true)) {
            // Class MyClass implements interface MyInterface
        }

        if (interface($factoryOrCommand, LazyCommand::class))
        return $factoryOrCommand();
    }

    public function getNames(): array
    {
        return array_keys($this->factoriesOrCommandsIndexedByCommandNames);
    }
}
