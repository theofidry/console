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

namespace Fidry\Console;

use Fidry\Console\Input\TypedInput;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\StringInput;
use Symfony\Component\Console\Output\NullOutput;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

/**
 * @psalm-import-type ArgumentInput from \Fidry\Console\InputAssert
 * @psalm-import-type OptionInput from \Fidry\Console\InputAssert
 */
final class IO extends SymfonyStyle
{
    use IOGetters;

    private InputInterface $input;
    private OutputInterface $output;

    public function __construct(InputInterface $input, OutputInterface $output)
    {
        parent::__construct($input, $output);

        $this->input = $input;
        $this->output = $output;
    }

    public static function createNull(): self
    {
        return new self(
            new StringInput(''),
            new NullOutput()
        );
    }

    public function getInput(): InputInterface
    {
        return $this->input;
    }

    public function isInteractive(): bool
    {
        return $this->input->isInteractive();
    }

    public function getOutput(): OutputInterface
    {
        return $this->output;
    }

    public function getArgument(string $name): TypedInput
    {
        return TypedInput::fromArgument(
            $this->input->getArgument($name)
        );
    }

    public function getOption(string $name): TypedInput
    {
        return TypedInput::fromOption(
            $this->input->getOption($name)
        );
    }

    /**
     * @return null|string|list<string>
     */
    private function getLegacyArgument(string $name)
    {
        $argument = $this->input->getArgument($name);

        InputAssert::assertIsValidArgumentType($argument);

        return $argument;
    }

    /**
     * @return null|bool|string|list<string>
     */
    private function getLegacyOption(string $name)
    {
        $option = $this->input->getOption($name);

        InputAssert::assertIsValidOptionType($option);

        return $option;
    }
}
