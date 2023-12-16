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
use Symfony\Component\Console\Formatter\OutputFormatterInterface;
use Symfony\Component\Console\Output\OutputInterface;
use function count;
use function func_get_args;

/**
 * @internal
 */
final class CombinedOutput implements OutputInterface
{
    /**
     * @var OutputInterface[]
     */
    private array $outputs;

    public function __construct(
        OutputInterface ...$outputs,
    ) {
        self::assertHasAtLeastOneOutput($outputs);

        $this->outputs = $outputs;
    }

    private function doWrite(string $message, bool $newline): void
    {
        // TODO: Implement doWrite() method.
    }

    /**
     * @param OutputInterface[] $outputs
     */
    private static function assertHasAtLeastOneOutput(array $outputs): void
    {
        if (count($outputs) < 1) {
            throw new DomainException('Expected at least one output.');
        }
    }

    public function write(iterable|string $messages, bool $newline = false, int $options = 0): void
    {
        foreach ($this->outputs as $output) {
            $output->write(...func_get_args());
        }
    }

    public function writeln(iterable|string $messages, int $options = 0): void
    {
        foreach ($this->outputs as $output) {
            $output->writeln(...func_get_args());
        }
    }

    public function setVerbosity(int $level): void
    {
        throw new DomainException('Should not called.');
    }

    public function getVerbosity(): int
    {
        throw new DomainException('Should not called.');
    }

    public function isQuiet(): bool
    {
        throw new DomainException('Should not called.');
    }

    public function isVerbose(): bool
    {
        throw new DomainException('Should not called.');
    }

    public function isVeryVerbose(): bool
    {
        throw new DomainException('Should not called.');
    }

    public function isDebug(): bool
    {
        throw new DomainException('Should not called.');
    }

    public function setDecorated(bool $decorated): void
    {
        throw new DomainException('Should not called.');
    }

    public function isDecorated(): bool
    {
        throw new DomainException('Should not called.');
    }

    public function setFormatter(OutputFormatterInterface $formatter): void
    {
        throw new DomainException('Should not called.');
    }

    public function getFormatter(): OutputFormatterInterface
    {
        throw new DomainException('Should not called.');
    }
}
