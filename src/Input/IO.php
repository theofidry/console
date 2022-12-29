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
 * @method string __toString()
 */
final class IO extends SymfonyStyle implements InputInterface, StyledOutput
{
    use DecoratesInput;

    private OutputInterface $output;
    private SymfonyStyle $styledOutput;

    public function __construct(
        InputInterface $input,
        OutputInterface $output
    ) {
        parent::__construct($input, $output);

        $this->input = $input;
        $this->output = $output;
        $this->styledOutput = new SymfonyStyle($output);
    }

    public static function createDefault(): self
    {
        return new self(
            new ArgvInput(),
            new ConsoleOutput(),
        );
    }

    public static function createNull(): self
    {
        return new self(
            new StringInput(''),
            new NullOutput(),
        );
    }

    public function getErrorIO(): self
    {
        return new self(
            $this->input,
            $this->getErrorOutput(),
        );
    }

    public function withInput(InputInterface $input): self
    {
        return new self($input, $this->output);
    }

    public function getInput(): InputInterface
    {
        return $this->input;
    }

    public function withOutput(OutputInterface $output): self
    {
        return new self($this->input, $output);
    }

    public function getOutput(): OutputInterface
    {
        return $this->output;
    }

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
}
