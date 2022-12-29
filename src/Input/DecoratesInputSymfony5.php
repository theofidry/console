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

/*
 * This file is part of the box project.
 *
 * (c) Kevin Herrera <kevin@herrera.io>
 *     Théo Fidry <theo.fidry@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Fidry\Console\Input;

use Symfony\Component\Console\Formatter\OutputFormatterInterface;
use Symfony\Component\Console\Helper\Table;
use Symfony\Component\Console\Input\ArgvInput;
use Symfony\Component\Console\Input\InputDefinition;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\StringInput;
use Symfony\Component\Console\Logger\ConsoleLogger;
use Symfony\Component\Console\Output\ConsoleOutput;
use Symfony\Component\Console\Output\NullOutput;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\Question;
use Symfony\Component\Console\Style\SymfonyStyle;
use function func_get_args;

/**
 * @psalm-require-implements InputInterface
 */
trait DecoratesInputSymfony5
{
    private InputInterface $input;

    /**
     * @param non-empty-string $name
     */
    public function getArgument(string $name): TypedInput
    {
        return TypedInput::fromArgument(
            $this->input->getArgument($name),
            $name,
        );
    }

    public function getFirstArgument(): ?string
    {
        return $this->input->getFirstArgument();
    }

    public function hasParameterOption($values, bool $onlyParams = false): bool
    {
        return $this->input->hasParameterOption(...func_get_args());
    }

    public function getParameterOption(
        $values,
        $default = false,
        bool $onlyParams = false
    ) {
        return $this->input->getParameterOption(...func_get_args());
    }

    public function bind(InputDefinition $definition)
    {
        return $this->input->bind($definition);
    }

    public function validate()
    {
        return $this->input->validate();
    }

    public function getArguments(): array
    {
        return $this->input->getArguments();
    }

    public function setArgument(string $name, $value)
    {
        return $this->input->setArgument(...func_get_args());
    }

    public function hasArgument(string $name): bool
    {
        return $this->input->hasArgument(...func_get_args());
    }

    public function getOptions(): array
    {
        return $this->input->getOptions();
    }

    public function setOption(string $name, $value)
    {
        return $this->input->setOption(...func_get_args());
    }

    /**
     * @param non-empty-string $name
     */
    public function getOption(string $name): TypedInput
    {
        return TypedInput::fromOption(
            $this->input->getOption($name),
            $name,
        );
    }

    /**
     * @param non-empty-string $name
     */
    public function hasOption(string $name, bool $onlyRealParams = false): bool
    {
        return $this->input->hasOption(...func_get_args());
    }

    public function isInteractive(): bool
    {
        return $this->input->isInteractive();
    }

    public function setInteractive(bool $interactive)
    {
        return $this->input->setInteractive(...func_get_args());
    }
}
