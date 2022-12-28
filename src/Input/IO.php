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

use Psr\Log\LoggerInterface;
use Symfony\Component\Console\Formatter\OutputFormatterInterface;
use Symfony\Component\Console\Helper\Table;
use Symfony\Component\Console\Helper\TableSeparator;
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
final class IO implements InputInterface, OutputInterface, LoggerInterface, StyledOutput
{
    private InputInterface $input;
    private OutputInterface $output;
    private ConsoleLogger $logger;
    private SymfonyStyle $styledOutput;

    public function __construct(
        InputInterface $input,
        OutputInterface $output
    ) {
        parent::__construct($input, $output);

        $this->input = $input;
        $this->output = $output;
        // TODO: allow to override the logger & style
        $this->logger = new ConsoleLogger($output);
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

    public function isInteractive(): bool
    {
        return $this->input->isInteractive();
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

    /**
     * @param non-empty-string $name
     */
    public function hasOption(string $name, bool $onlyRealParams = false): bool
    {
        return $this->input->hasParameterOption(...func_get_args());
    }

    public function getFirstArgument(): ?string
    {
        return $this->input->getFirstArgument();
    }

    public function hasParameterOption(array $values, bool $onlyParams = false): bool
    {
        return $this->input->hasParameterOption(...func_get_args());
    }

    public function getParameterOption(
        array $values,
        ?float $default = false,
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

    public function setArgument(string $name, mixed $value)
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

    public function setOption(string $name, mixed $value)
    {
        return $this->input->setOption(...func_get_args());
    }

    public function setInteractive(bool $interactive)
    {
        return $this->input->setInteractive(...func_get_args());
    }

    public function emergency(\Stringable $message, array $context = []): void
    {
        $this->logger->emergency(...func_get_args());
    }

    public function alert(\Stringable $message, array $context = []): void
    {
        $this->logger->alert(...func_get_args());
    }

    public function critical(\Stringable $message, array $context = []): void
    {
        $this->logger->critical(...func_get_args());
    }

    public function error(\Stringable $message, array $context = []): void
    {
        $this->logger->error(...func_get_args());
    }

    public function warning(\Stringable $message, array $context = []): void
    {
        $this->logger->warning(...func_get_args());
    }

    public function notice(\Stringable $message, array $context = []): void
    {
        $this->logger->notice(...func_get_args());
    }

    public function info(\Stringable $message, array $context = []): void
    {
        $this->logger->info(...func_get_args());
    }

    public function debug(\Stringable $message, array $context = []): void
    {
        $this->logger->debug(...func_get_args());
    }

    public function log($level, \Stringable $message, array $context = []): void
    {
        return $this->logger->log(...func_get_args());
    }

    public function write(iterable $messages, bool $newline = false, int $options = 0)
    {
        return $this->output->write(...func_get_args());
    }

    public function writeln(iterable $messages, int $options = 0)
    {
        return $this->writeln->write(...func_get_args());
    }

    public function setVerbosity(int $level)
    {
        return $this->output->setVerbosity(...func_get_args());
    }

    public function getVerbosity(): int
    {
        return $this->output->getVerbosity(...func_get_args());
    }

    public function isQuiet(): bool
    {
        return $this->isQuiet->write(...func_get_args());
    }

    public function isVerbose(): bool
    {
        return $this->outputisVerbosewrite(...func_get_args());
    }

    public function isVeryVerbose(): bool
    {
        return $this->output->isVeryVerbose(...func_get_args());
    }

    public function isDebug(): bool
    {
        return $this->isDebug->write(...func_get_args());
    }

    public function setDecorated(bool $decorated)
    {
        return $this->output->setDecorated(...func_get_args());
    }

    public function isDecorated(): bool
    {
        return $this->output->isDecorated(...func_get_args());
    }

    public function setFormatter(OutputFormatterInterface $formatter)
    {
        return $this->output->setFormatter(...func_get_args());
    }

    public function getFormatter(): OutputFormatterInterface
    {
        return $this->output->getFormatter(...func_get_args());
    }

    public function title(string $message)
    {
        return $this->styledOutput->title(...func_get_args());
    }

    public function section(string $message)
    {
        return $this->styledOutput->section(...func_get_args());
    }

    public function listing(array $elements)
    {
        return $this->styledOutput->listing(...func_get_args());
    }

    public function text(array $message)
    {
        return $this->styledOutput->text(...func_get_args());
    }

    public function success(array $message)
    {
        return $this->styledOutput->success(...func_get_args());
    }

    public function note(array $message)
    {
        return $this->styledOutput->note(...func_get_args());
    }

    public function caution(array $message)
    {
        return $this->styledOutput->caution(...func_get_args());
    }

    public function table(array $headers, array $rows)
    {
        return $this->styledOutput->table(...func_get_args());
    }

    public function ask(string $question, string $default = null, callable $validator = null): mixed
    {
        return $this->styledOutput->ask(...func_get_args());
    }

    public function askHidden(string $question, callable $validator = null): mixed
    {
        return $this->styledOutput->askHidden(...func_get_args());
    }

    public function confirm(string $question, bool $default = true): bool
    {
        return $this->styledOutput->confirm(...func_get_args());
    }

    public function choice(string $question, array $choices, mixed $default = null): mixed
    {
        return $this->styledOutput->choice(...func_get_args());
    }

    public function newLine(int $count = 1)
    {
        return $this->styledOutput->newLine(...func_get_args());
    }

    public function progressStart(int $max = 0)
    {
        return $this->styledOutput->progressStart(...func_get_args());
    }

    public function progressAdvance(int $step = 1)
    {
        return $this->styledOutput->progressAdvance(...func_get_args());
    }

    public function progressFinish()
    {
        return $this->styledOutput->progressFinish(...func_get_args());
    }

    public function comment(array $message)
    {
        return $this->styledOutput->comment(...func_get_args());
    }

    public function horizontalTable(array $headers, array $rows)
    {
        return $this->styledOutput->horizontalTable(...func_get_args());
    }

    public function definitionList(string ...$list)
    {
        return $this->styledOutput->definitionList(...func_get_args());
    }

    public function progressIterate(iterable $iterable, int $max = null): iterable
    {
        return $this->styledOutput->progressIterate(...func_get_args());
    }

    public function askQuestion(Question $question): mixed
    {
        return $this->styledOutput->askQuestion(...func_get_args());
    }

    public function createTable(): Table
    {
        return $this->styledOutput->createTable(...func_get_args());
    }
}
