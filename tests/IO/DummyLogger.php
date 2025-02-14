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
use Composer\InstalledVersions;
use Composer\Semver\VersionParser;
use Psr\Log\LoggerInterface;
use Psr\Log\LoggerTrait;
use Stringable;
use Symfony\Component\Console\Output\OutputInterface;
use function func_get_args;

$isPsrLog3 = InstalledVersions::satisfies(
    new VersionParser(),
    'psr/log',
    '^3.0',
);

if ($isPsrLog3) {
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

        public function log(mixed $level, string|Stringable $message, array $context = []): void
        {
            $this->records[] = func_get_args();
        }
    }
} else {
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

        public function log($level, $message, $context = [])
        {
            $this->records[] = func_get_args();
        }
    }
}
