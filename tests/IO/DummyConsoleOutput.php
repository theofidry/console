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

namespace Fidry\Console\Tests\IO;

use DomainException;
use Fidry\Console\Input\DecoratesOutput;
use Symfony\Component\Console\Output\ConsoleOutputInterface;
use Symfony\Component\Console\Output\ConsoleSectionOutput;
use Symfony\Component\Console\Output\OutputInterface;

final class DummyConsoleOutput implements ConsoleOutputInterface
{
    use DecoratesOutput;

    private OutputInterface $errorOutput;

    public function __construct(
        OutputInterface $output,
        OutputInterface $errorOutput
    ) {
        $this->output = $output;
        $this->errorOutput = $errorOutput;
    }

    public function getErrorOutput(): OutputInterface
    {
        return $this->errorOutput;
    }

    public function setErrorOutput(OutputInterface $error): void
    {
        $this->errorOutput = $error;
    }

    public function section(): ConsoleSectionOutput
    {
        throw new DomainException('Not supported.');
    }
}
