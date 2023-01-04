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

use Closure;
use Fidry\Console\Input\DecoratesInput;
use Fidry\Console\Input\TypedInput;
use Fidry\Console\Output\DecoratesLogger;
use Fidry\Console\Output\DecoratesOutput;
use Fidry\Console\Output\DecoratesStyledOutput;
use Fidry\Console\Output\StyledOutput;
use Fidry\Console\Output\SymfonyStyledOutput;
use Psr\Log\LoggerInterface;
use Symfony\Component\Console\Input\ArgvInput;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\StringInput;
use Symfony\Component\Console\Logger\ConsoleLogger;
use Symfony\Component\Console\Output\ConsoleOutput;
use Symfony\Component\Console\Output\ConsoleOutputInterface;
use Symfony\Component\Console\Output\NullOutput;
use Symfony\Component\Console\Output\OutputInterface;

final class IO implements InputInterface, OutputInterface, StyledOutput
{
    use DecoratesInput;
    use DecoratesLogger;
    use DecoratesOutput;
    use DecoratesStyledOutput;

    /**
     * @var Closure(InputInterface, OutputInterface): StyledOutput
     */
    private Closure $styledOutputFactory;
    private StyledOutput $styledErrorOutput;

    /**
     * @var Closure(OutputInterface): LoggerInterface
     */
    private Closure $loggerFactory;
    private LoggerInterface $errorLogger;

    /**
     * @param null|Closure(InputInterface, OutputInterface): StyledOutput $styledOutputFactory
     * @param null|Closure(OutputInterface): LoggerInterface              $loggerFactory
     */
    public function __construct(
        InputInterface $input,
        OutputInterface $output,
        ?Closure $styledOutputFactory = null,
        ?Closure $loggerFactory = null
    ) {
        $this->styledOutputFactory = $styledOutputFactory ?? static fn (InputInterface $input, OutputInterface $output): StyledOutput => new SymfonyStyledOutput($input, $output);
        $this->loggerFactory = $loggerFactory ?? static fn (OutputInterface $output): LoggerInterface => new ConsoleLogger($output);

        $this->input = $input;
        $this->output = $output;
        $this->styledOutput = ($this->styledOutputFactory)($input, $output);
        $this->styledErrorOutput = ($this->styledOutputFactory)($input, $this->getErrorOutput());
        $this->logger = ($this->loggerFactory)($output);
        $this->errorLogger = ($this->loggerFactory)($this->getErrorOutput());
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
            $this->styledOutputFactory,
            $this->loggerFactory,
        );
    }

    public function withInput(InputInterface $input): self
    {
        return new self(
            $input,
            $this->output,
            $this->styledOutputFactory,
            $this->loggerFactory,
        );
    }

    public function getInput(): InputInterface
    {
        return $this->input;
    }

    public function withOutput(OutputInterface $output): self
    {
        return new self(
            $this->input,
            $output,
            $this->styledOutputFactory,
            $this->loggerFactory,
        );
    }

    public function getOutput(): OutputInterface
    {
        return $this->output;
    }

    public function getErrorOutput(): OutputInterface
    {
        return $this->output instanceof ConsoleOutputInterface
            ? $this->output->getErrorOutput()
            : $this->output;
    }

    /**
     * @param null|Closure(InputInterface, OutputInterface): StyledOutput $styledOutputFactory
     */
    public function withStyledOutputFactory(?Closure $styledOutputFactory): self
    {
        return new self(
            $this->input,
            $this->output,
            $styledOutputFactory,
            $this->loggerFactory,
        );
    }

    public function getStyledOutput(): StyledOutput
    {
        return $this->styledOutput;
    }

    public function getStyledErrorOutput(): StyledOutput
    {
        return $this->styledErrorOutput;
    }

    /**
     * @param null|Closure(OutputInterface): LoggerInterface $loggerFactory
     */
    public function withLoggerFactory(?Closure $loggerFactory): self
    {
        return new self(
            $this->input,
            $this->output,
            $this->styledOutputFactory,
            $loggerFactory,
        );
    }

    public function getLogger(): LoggerInterface
    {
        return $this->logger;
    }

    public function getErrorLogger(): LoggerInterface
    {
        return $this->errorLogger;
    }

    /**
     * @param non-empty-string $name
     */
    public function getTypedArgument(string $name): TypedInput
    {
        return TypedInput::fromArgument(
            $this->input->getArgument($name),
            $name,
        );
    }

    /**
     * @param non-empty-string $name
     */
    public function getTypedOption(string $name): TypedInput
    {
        return TypedInput::fromOption(
            $this->input->getOption($name),
            $name,
        );
    }
}
