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
use Symfony\Component\Console\Formatter\OutputFormatterInterface;
use Symfony\Component\Console\Helper\ProgressBar;
use Symfony\Component\Console\Helper\Table;
use Symfony\Component\Console\Helper\TableSeparator;
use Symfony\Component\Console\Input\ArgvInput;
use Symfony\Component\Console\Input\InputDefinition;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\StringInput;
use Symfony\Component\Console\Logger\ConsoleLogger;
use Symfony\Component\Console\Output\ConsoleOutput;
use Symfony\Component\Console\Output\ConsoleOutputInterface;
use Symfony\Component\Console\Output\NullOutput;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\Question;

/**
 * Note that all of this faff is about supporting Symfony5 & Symfony6 together.
 * It is otherwise much simpler.
 *
 * Input methods.
 *
 * @method getArgument(string $name): mixed
 * @method getFirstArgument(): ?string
 * @method hasParameterOption(string|array $values, bool $onlyParams = false): bool
 * @method getParameterOption(string|array $values, string|bool|int|float|array|null $default = false, bool $onlyParams = false): mixed
 * @method bind(InputDefinition $definition)
 * @method validate(): void
 * @method getArguments(): array
 * @method setArgument(string $name, mixed $value)
 * @method hasArgument(string $name): bool
 * @method getOptions(): array
 * @method setOption(string $name, mixed $value)
 * @method getOption(string $name): mixed
 * @method hasOption(string $name, bool $onlyRealParams = false): bool
 * @method isInteractive(): bool
 * @method setInteractive(bool $interactive)
 *
 * Logger methods.
 *
 * @method logEmergency(string|Stringable $message, array $context = []): void
 * @method logCritical(string|Stringable $message, array $context = []): void
 * @method logError(string|Stringable $message, array $context = []): void
 * @method logWarning(string|Stringable $message, array $context = []): void
 * @method logNotice(string|Stringable $message, array $context = []): void
 * @method logInfo(string|Stringable $message, array $context = []): void
 * @method logDebug(string|Stringable $message, array $context = []): void
 * @method log(mixed $level, string|Stringable $message, array $context = []): void
 *
 * Output methods.
 *
 * @method write(string|iterable $messages, bool $newline = false, int $options = 0)
 * @method writeln(string|iterable $messages, int $options = 0)
 * @method setVerbosity(int $level)
 * @method getVerbosity(): int
 * @method isQuiet(): bool
 * @method isVerbose(): bool
 * @method isVeryVerbose(): bool
 * @method isDebug(): bool
 * @method setDecorated(bool $decorated)
 * @method isDecorated(): bool
 * @method setFormatter(OutputFormatterInterface $formatter)
 * @method getFormatter(): OutputFormatterInterface
 *
 * Styled output methods.
 *
 * @method block(string|array $messages, ?string $type = null, ?string $style = null, string $prefix = ' ', bool $padding = false, bool $escape = true)
 * @method title(string $message)
 * @method section(string $message)
 * @method listing(array $elements)
 * @method text(string|array $message)
 * @method comment(string|array $message)
 * @method success(string|array $message)
 * @method error(string|array $message)
 * @method warning(string|array $message)
 * @method note(string|array $message)
 * @method info(string|array $message)
 * @method caution(string|array $message)
 * @method table(array $headers, array $rows)
 * @method horizontalTable(array $headers, array $rows)
 * @method definitionList(string|array|TableSeparator ...$list)
 * @method ask(string $question, ?string $default = null, ?callable $validator = null): mixed
 * @method askHidden(string $question, ?callable $validator = null): mixed
 * @method confirm(string $question, bool $default = true): bool
 * @method choice(string $question, array $choices, mixed $default = null, bool $multiSelect = false): mixed
 * @method progressStart(int $max = 0)
 * @method progressAdvance(int $step = 1)
 * @method progressFinish()
 * @method createProgressBar(int $max = 0): ProgressBar
 * @method progressIterate(iterable $iterable, ?int $max = null): iterable
 * @method askQuestion(Question $question): mixed
 * @method newLine(int $count = 1)
 * @method createTable(): Table
 */
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
            new StringInput(''),
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
