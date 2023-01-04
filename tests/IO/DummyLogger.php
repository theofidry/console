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

use Closure;
use Psr\Log\LoggerInterface;
use Psr\Log\LoggerTrait;
use Symfony\Component\Console\Output\OutputInterface;
use function func_get_args;

final class DummyLogger implements LoggerInterface
{
    public array $records;

    use LoggerTrait;

    /**
     * @return Closure(OutputInterface):LoggerInterface
     */
    public static function getFactory(): Closure
    {
        /** @psalm-suppress UnusedClosureParam */
        return static fn (OutputInterface $output): LoggerInterface => new self();
    }

    public function log($level, $message, array $context = []): void
    {
        $this->records[] = func_get_args();
    }
}
