<?php

namespace Fidry\Console\CommandLoader;

use Fidry\Console\Command\Command;
use Symfony\Component\Console\Exception\CommandNotFoundException;

interface CommandLoader
{
    /**
     * Loads a command.
     *
     * @throws CommandNotFoundException
     */
    public function get(string $name): Command;

    public function has(string $name): bool;

    /**
     * @return list<string>
     */
    public function getNames(): array;
}