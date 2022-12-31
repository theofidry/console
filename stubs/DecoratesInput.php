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

use Symfony\Component\Console\Input\InputDefinition;
use Symfony\Component\Console\Input\InputInterface;
use function func_get_args;

/**
 * @internal
 * @psalm-require-implements InputInterface
 */
trait DecoratesInput
{
    private InputInterface $input;

    public function getArgument(string $name): mixed
    {
        return $this->input->getArgument($name);
    }

    public function getFirstArgument(): ?string
    {
        return $this->input->getFirstArgument();
    }

    public function hasParameterOption(string|array $values, bool $onlyParams = false): bool
    {
        return $this->input->hasParameterOption(...func_get_args());
    }

    public function getParameterOption(
        string|array $values,
        string|bool|int|float|array|null $default = false,
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

    /** @psalm-suppress LessSpecificImplementedReturnType */
    public function getArguments(): array
    {
        return $this->input->getArguments();
    }

    public function setArgument(string $name, mixed $value)
    {
        return $this->input->setArgument(...func_get_args());
    }

    public function hasArgument(string $name): bool
    {
        return $this->input->hasArgument(...func_get_args());
    }

    /** @psalm-suppress LessSpecificImplementedReturnType */
    public function getOptions(): array
    {
        return $this->input->getOptions();
    }

    public function setOption(string $name, mixed $value)
    {
        return $this->input->setOption(...func_get_args());
    }

    public function getOption(string $name): mixed
    {
        return $this->input->getOption(...func_get_args());
    }

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