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

use DomainException;
use RuntimeException;
use Symfony\Component\Console\Formatter\OutputFormatterInterface;
use Symfony\Component\Console\Output\ConsoleOutputInterface;
use Symfony\Component\Console\Output\ConsoleSectionOutput;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Output\StreamOutput;
use function fopen;
use function func_get_args;
use function rewind;
use function stream_get_contents;

final class TestOutput implements ConsoleOutputInterface
{
    private OutputInterface $innerOutput;
    private OutputInterface $innerErrorOutput;
    private OutputInterface $displayOutput;
    private CombinedOutput $output;
    private CombinedOutput $errorOutput;

    /**
     * @param OutputInterface::VERBOSITY_* $verbosity
     */
    public function __construct(
        private int $verbosity,
        private bool $decorated,
        private OutputFormatterInterface $formatter,
    ) {
        $this->innerOutput = self::createOutput($this);
        $this->innerErrorOutput = self::createOutput($this);
        $this->displayOutput = self::createOutput($this);

        $this->output = new CombinedOutput(
            $this->innerOutput,
            $this->displayOutput,
        );
        $this->errorOutput = new CombinedOutput(
            $this->innerErrorOutput,
            $this->displayOutput,
        );
    }

    public function getOutputContents(): string
    {
        return self::getStreamContents($this->innerOutput);
    }

    public function getErrorOutputContents(): string
    {
        return self::getStreamContents($this->innerErrorOutput);
    }

    public function getDisplayContents(): string
    {
        return self::getStreamContents($this->displayOutput);
    }

    public function getErrorOutput(): OutputInterface
    {
        return $this->errorOutput;
    }

    public function setErrorOutput(OutputInterface $error): void
    {
        throw new DomainException('Should not be modified.');
    }

    public function section(): ConsoleSectionOutput
    {
        throw new DomainException('Not supported (yet).');
    }

    public function write(iterable|string $messages, bool $newline = false, int $options = 0): void
    {
        $this->output->write(...func_get_args());
    }

    public function writeln(iterable|string $messages, int $options = 0): void
    {
        $this->output->writeln(...func_get_args());
    }

    public function setVerbosity(int $level): void
    {
        throw new DomainException('Should not be modified.');
    }

    public function getVerbosity(): int
    {
        return $this->verbosity;
    }

    public function isQuiet(): bool
    {
        return self::VERBOSITY_QUIET === $this->verbosity;
    }

    public function isVerbose(): bool
    {
        return self::VERBOSITY_VERBOSE <= $this->verbosity;
    }

    public function isVeryVerbose(): bool
    {
        return self::VERBOSITY_VERY_VERBOSE <= $this->verbosity;
    }

    public function isDebug(): bool
    {
        return self::VERBOSITY_DEBUG <= $this->verbosity;
    }

    public function setDecorated(bool $decorated): void
    {
        throw new DomainException('Should not be modified.');
    }

    public function isDecorated(): bool
    {
        return $this->formatter->isDecorated();
    }

    public function setFormatter(OutputFormatterInterface $formatter): void
    {
        throw new DomainException('Should not be modified.');
    }

    public function getFormatter(): OutputFormatterInterface
    {
        return $this->formatter;
    }

    private static function createOutput(OutputInterface $config): StreamOutput
    {
        $stream = fopen('php://memory', 'wb');

        if (false === $stream) {
            throw new RuntimeException('Failed to open stream.');
        }

        return new StreamOutput(
            $stream,
            $config->getVerbosity(),
            $config->isDecorated(),
            $config->getFormatter(),
        );
    }

    private static function getStreamContents(StreamOutput $output): string
    {
        $stream = $output->getStream();

        rewind($stream);

        return stream_get_contents($stream);
    }
}
