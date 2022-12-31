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

namespace Fidry\Console\Input\Compatibility;

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
trait DecoratesLoggerPsr1
{
    private LoggerInterface $logger;

    public function emergency($message, array $context = array())
    {
        $this->logger->emergency(...func_get_args());
    }
    public function alert($message, array $context = array())
    {
        $this->logger->alert(...func_get_args());
    }
    public function critical($message, array $context = array())
    {
        $this->logger->critical(...func_get_args());
    }
    public function error($message, array $context = array())
    {
        $this->logger->error(...func_get_args());
    }
    public function warning($message, array $context = array())
    {
        $this->logger->warning(...func_get_args());
    }
    public function notice($message, array $context = array())
    {
        $this->logger->notice(...func_get_args());
    }
    public function info($message, array $context = array())
    {
        $this->logger->info(...func_get_args());
    }
    public function debug($message, array $context = array())
    {
        $this->logger->debug(...func_get_args());
    }
    public function log($level, $message, array $context = array())
    {
        $this->logger->log(...func_get_args());
    }
}
