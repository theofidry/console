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

use Fidry\Console\Input\StyledOutput;
use Psr\Log\LoggerInterface;
use Symfony\Component\Console\Helper\ProgressBar;
use Symfony\Component\Console\Helper\Table;
use Symfony\Component\Console\Helper\TableSeparator;
use Symfony\Component\Console\Question\Question;
use function func_get_args;
use Stringable;

/**
 * @internal
 * @psalm-require-implements LoggerInterface
 */
trait DecoratesLogger
{
    private LoggerInterface $logger;

    public function emergency(string|Stringable $message, array $context = [])
    {
        $this->logger->emergency(...func_get_args());
    }

    public function alert(string|Stringable $message, array $context = [])
    {
        $this->logger->alert(...func_get_args());
    }

    public function critical(string|Stringable $message, array $context = [])
    {
        $this->logger->critical(...func_get_args());
    }

    public function error(string|Stringable $message, array $context = [])
    {
        $this->logger->error(...func_get_args());
    }

    public function warning(string|Stringable $message, array $context = [])
    {
        $this->logger->warning(...func_get_args());
    }

    public function notice(string|Stringable $message, array $context = [])
    {
        $this->logger->notice(...func_get_args());
    }

    public function info(string|Stringable $message, array $context = [])
    {
        $this->logger->info(...func_get_args());
    }

    public function debug(string|Stringable $message, array $context = [])
    {
        $this->logger->debug(...func_get_args());
    }

    public function log($level, string|Stringable $message, array $context = [])
    {
        $this->logger->log(...func_get_args());
    }
}
