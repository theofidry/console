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

namespace Fidry\Console\Test;

use Fidry\Console\Bridge\Command\SymfonyCommand;
use Fidry\Console\Command\Command;
use Fidry\Console\Output\Formatter\DefaultFormatterFactory;
use Fidry\Console\Output\Formatter\OutputFormatterFactory;
use Symfony\Component\Console\Application;
use Symfony\Component\Console\Command\Command as BaseSymfonyCommand;
use Symfony\Component\Console\Formatter\OutputFormatter;
use Symfony\Component\Console\Formatter\OutputFormatterInterface;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Webmozart\Assert\Assert;
use function array_merge;
use function fopen;
use function fwrite;
use function rewind;
use const PHP_EOL;

class CommandTester
{
    private OutputFormatterFactory $formatterFactory;

    /**
     * If your command does not depend on any special behavior from the console, this static factory will probably be
     * good enough for you.
     * Otherwise, consider using the AppTester!
     */
    public static function fromConsoleCommand(Command $command): static
    {
        // A bare-bone application is needed to execute the Symfony CommandTester as what it does is configuring the
        // application and using it to execute the command.
        $application = new Application();

        $executableCommand = $application->add(
            new SymfonyCommand($command),
        );
        Assert::notNull($executableCommand);

        return new self($executableCommand);
    }

    public function __construct(
        private BaseSymfonyCommand $command,
        // See Symfony's Output::__construct()
        // We use the same default values.
        private array $inputs = [],
        private bool $interactive = false,
        private bool $decorated = false,
        private ?int $verbosity = OutputInterface::VERBOSITY_NORMAL,
        ?OutputFormatterFactory $formatterFactory = null,
    ) {
        $this->formatterFactory = $formatterFactory ?? new DefaultFormatterFactory(
            // See Symfony's Output::__construct()
            // We use the same default value.
            static fn () => new OutputFormatter(),
        );
    }

    /**
     * @param array $inputs An array of strings representing each input
     *                      passed to the command input stream
     */
    public function setInputs(array $inputs): static
    {
        $this->inputs = $inputs;

        return $this;
    }

    /**
     * Represents an input passed to the command input stream.
     */
    public function setInput(string $name, mixed $value): static
    {
        $this->inputs[$name] = $value;

        return $this;
    }

    public function setInteractive(bool $interactive = true): static
    {
        $this->interactive = $interactive;

        return $this;
    }

    public function setDecorated(bool $decorated = true): static
    {
        $this->decorated = $decorated;

        return $this;
    }

    /**
     * @param OutputInterface::VERBOSITY_* $verbosity
     */
    public function setVerbosity(int $verbosity): static
    {
        $this->verbosity = $verbosity;

        return $this;
    }

    /**
     * Executes the command.
     *
     * @param array $input An array of command arguments and options
     */
    public function execute(array $input): ExecutionResult
    {
        $this->addCommandArgumentIfNecessary($input);

        $configuredInput = $this->createInput($input);

        $testOutput = new TestOutput(
            $this->verbosity,
            $this->decorated,
            $this->createFormatter(),
        );

        $statusCode = $this->command->run($configuredInput, $testOutput);

        return ExecutionResult::fromTestOutput(
            $configuredInput->__toString(),
            $statusCode,
            $testOutput,
        );
    }

    private function addCommandArgumentIfNecessary(array $input): array
    {
        if (isset($input['command'])) {
            return $input;
        }

        $application = $this->command->getApplication();

        return null !== $application && $application->getDefinition()->hasArgument('command')
            ? array_merge(
                ['command' => $this->command->getName()],
                $input,
            )
            : $input;
    }

    private function createInput(array $rawInput): InputInterface
    {
        $input = new ArrayInput($rawInput);

        // Use an in-memory input stream even if no inputs are set so that QuestionHelper::ask() does not rely on the blocking STDIN.
        $input->setStream(self::createStream($this->inputs));

        $input->setInteractive($this->interactive);

        return $input;
    }

    private function createFormatter(): OutputFormatterInterface
    {
        $formatter = $this->formatterFactory->create();
        $formatter->setDecorated($this->decorated);

        return $formatter;
    }

    /**
     * @return resource
     */
    private static function createStream(array $inputs)
    {
        $stream = fopen('php://memory', 'rb+');

        foreach ($inputs as $input) {
            fwrite($stream, $input.PHP_EOL);
        }

        rewind($stream);

        return $stream;
    }
}
