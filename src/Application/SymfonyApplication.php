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

namespace Fidry\Console\Application;

use Fidry\Console\Command\Command;
use Fidry\Console\Command\Command;
use Fidry\Console\Command\Command as FidryCommand;
use Fidry\Console\Command\LazyCommand;
use Fidry\Console\Command\LazyCommand;
use Fidry\Console\Command\LazyCommand as FidryLazyCommand;
use Fidry\Console\Command\SymfonyCommand;
use Fidry\Console\Command\SymfonyCommandFactory;
use Fidry\Console\CommandLoader\CompositeCommandLoader;
use Fidry\Console\CommandLoader\FactoryCommandLoader;
use Fidry\Console\CommandLoader\SymfonyCommandLoader;
use Fidry\Console\IO;
use LogicException;
use Symfony\Component\Console\Application as BaseSymfonyApplication;
use Symfony\Component\Console\Command\Command as BaseSymfonyCommand;
use Symfony\Component\Console\Command\LazyCommand as SymfonyLazyCommand;
use Symfony\Component\Console\CommandLoader\CommandLoaderInterface;
use Symfony\Component\Console\Helper\HelperSet;
use Symfony\Component\Console\Input\InputDefinition;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Contracts\Service\ResetInterface;
use function array_map;
use function array_values;

/**
 * Bridge to create a traditional Symfony application from the new Application
 * API.
 */
final class SymfonyApplication extends BaseSymfonyApplication
{
    public function __construct(
        private Application $application,
        private SymfonyCommandFactory $symfonyCommandFactory,
    ) {
        parent::__construct(
            $application->getName(),
            $application->getVersion(),
        );

        $this->setDefaultCommand($application->getDefaultCommand());
        $this->setAutoExit($application->isAutoExitEnabled());
        $this->setCatchExceptions($application->areExceptionsCaught());

        $this->registerCommands($this->application);
    }

    public function reset(): void
    {
        if ($this->application instanceof ResetInterface) {
            $this->application->reset();
        }
    }

    public function setHelperSet(HelperSet $helperSet): void
    {
        throw new LogicException('Not supported');
    }

    public function setDefinition(InputDefinition $definition): void
    {
        throw new LogicException('Not supported');
    }

    public function getHelp(): string
    {
        return $this->application->getHelp();
    }

    public function getLongVersion(): string
    {
        return $this->application->getLongVersion();
    }

    public function setCommandLoader(CommandLoaderInterface $commandLoader): void
    {
        throw new LogicException('Not supported');
    }

    public function setSignalsToDispatchEvent(int ...$signalsToDispatchEvent): void
    {
        throw new LogicException('Not supported');
    }

    public function setName(string $name): void
    {
        throw new LogicException('Not supported');
    }

    public function setVersion(string $version): void
    {
        throw new LogicException('Not supported');
    }

    protected function configureIO(InputInterface $input, OutputInterface $output): void
    {
        parent::configureIO($input, $output);

        if ($this->application instanceof ConfigurableIO) {
            $this->application->configureIO(
                new IO($input, $output),
            );
        }
    }

    protected function getDefaultCommands(): array
    {
        return [
            ...parent::getDefaultCommands(),
            ...$this->getSymfonyCommands(),
        ];
    }

    /**
     * @param array<string|array-key, class-string<LazyCommand>|class-string<Command>|Command|callable():Command> $commands
     *
     * @return array{list<Command>, array<string|array-key, class-string<LazyCommand>|class-string<Command>|callable():Command>}
     */
    private static function getCommands(array $commands): array
    {
        $nonLazyCommands = [];
        $lazyCommands = [];

        foreach ($commands as $nameOrIndex => $command) {
            if ($command instanceof Command) {
                $nonLazyCommands[] = $command;
            } else {
                $lazyCommands[$nameOrIndex] = $command;
            }
        }

        return [$nonLazyCommands, $lazyCommands];
    }

    private function registerCommands(Application $application): void
    {
        [$commands, $lazyCommands] = self::getCommands($this->application->getCommands());

        foreach ($commands as $command) {
            $this->add($this->symfonyCommandFactory->crateSymfonyCommand($command));
        }

        $commandLoader = new FactoryCommandLoader($lazyCommands);

        if ($application instanceof HasCommandLoader) {
            $commandLoader = new CompositeCommandLoader(
                $commandLoader,
                $application->getCommandLoader(),
            );
        }

        $this->setCommandLoader(
            new SymfonyCommandLoader(
                $commandLoader,
                $this->symfonyCommandFactory,
            ),
        );
    }

    /**
     * @return list<BaseSymfonyCommand>
     */
    private function getSymfonyCommands(): array
    {
        return array_values(
            array_map(
                static fn (FidryCommand $command) => $this->symfonyCommandFactory->crateSymfonyCommand($command),
                $this->application->getCommands(),
            ),
        );
    }
}
