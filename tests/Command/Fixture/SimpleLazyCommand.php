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

namespace Fidry\Console\Tests\Command\Fixture;

use Fidry\Console\Command\Configuration;
use Fidry\Console\Command\LazyCommand;
use Fidry\Console\ExitCode;
use Fidry\Console\Input\IO;
use Fidry\Console\Tests\StatefulService;

final class SimpleLazyCommand implements LazyCommand
{
    public function __construct(StatefulService $service)
    {
        $service->call();
    }

    public static function getName(): string
    {
        return 'app:lazy';
    }

    public static function getDescription(): string
    {
        return 'lazy command description';
    }

    public function getConfiguration(): Configuration
    {
        return new Configuration(
            'app:not-lazy',
            'non-lazy description',
            '',
        );
    }

    public function execute(IO $io): int
    {
        return ExitCode::SUCCESS;
    }
}
