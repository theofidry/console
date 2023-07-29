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
use Fidry\Console\Command\Command;
use Fidry\Console\Command\Configuration;
use Fidry\Console\Command\LazyCommand;
use Fidry\Console\IO;

final class ManualLazyCommand implements LazyCommand
{
    /** @psalm-suppress PropertyNotSetInConstructor */
    private Command $command;

    /**
     * @param Closure():Command $commandFactory
     */
    public function __construct(
        private readonly Closure $commandFactory,
    ) {
    }

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
            $this->command = ($this->commandFactory)();
        }

        return $this->command;
    }
}
