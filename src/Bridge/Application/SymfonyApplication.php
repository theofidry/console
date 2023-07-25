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

namespace Fidry\Console\Bridge\Application;

use Fidry\Console\Application\Application;
use Fidry\Console\Application\ConfigurableIO;
use Fidry\Console\Bridge\Command\SymfonyCommandFactory;
use Fidry\Console\IO;
use LogicException;
use Symfony\Component\Console\Application as BaseSymfonyApplication;
use Symfony\Component\Console\Command\Command as BaseSymfonyCommand;
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
        private readonly Application $application,
        private readonly SymfonyCommandFactory $commandFactory,
    ) {
        parent::__construct(
            $application->getName(),
            $application->getVersion(),
        );

        $this->setDefaultCommand($application->getDefaultCommand());
        $this->setAutoExit($application->isAutoExitEnabled());
        $this->setCatchExceptions($application->areExceptionsCaught());
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
     * @return list<BaseSymfonyCommand>
     */
    private function getSymfonyCommands(): array
    {
        return array_values(
            array_map(
                $this->commandFactory->crateSymfonyCommand(...),
                $this->application->getCommands(),
            ),
        );
    }
}
