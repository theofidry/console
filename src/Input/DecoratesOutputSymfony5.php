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
use Symfony\Component\Console\Input\InputDefinition;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use function func_get_args;

/**
 * @internal
 * @psalm-require-implements OutputInterface
 */
trait DecoratesOutputSymfony5
{
    private OutputInterface $output;

    public function write($messages, bool $newline = false, int $options = 0)
    {
        return $this->output->write(...func_get_args());
    }

    public function writeln($messages, int $options = 0)
    {
        return $this->output->writeln(...func_get_args());
    }

    public function setVerbosity(int $level)
    {
        return $this->output->setVerbosity(...func_get_args());
    }

    public function getVerbosity()
    {
        return $this->output->getVerbosity(...func_get_args());
    }

    public function isQuiet()
    {
        return $this->output->isQuiet(...func_get_args());
    }

    public function isVerbose()
    {
        return $this->output->isVerbose(...func_get_args());
    }

    public function isVeryVerbose()
    {
        return $this->output->isVeryVerbose(...func_get_args());
    }

    public function isDebug()
    {
        return $this->output->isDebug(...func_get_args());
    }

    public function setDecorated(bool $decorated)
    {
        return $this->output->setDecorated(...func_get_args());
    }

    public function isDecorated()
    {
        return $this->output->isDecorated(...func_get_args());
    }

    public function setFormatter(OutputFormatterInterface $formatter)
    {
        return $this->output->setFormatter(...func_get_args());
    }

    public function getFormatter()
    {
        return $this->output->getFormatter(...func_get_args());
    }
}
