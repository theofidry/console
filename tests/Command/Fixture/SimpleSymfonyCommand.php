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

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

final class SimpleSymfonyCommand extends Command
{
    public function __construct()
    {
        parent::__construct('symfony-cmd');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        // Do nothing.

        return self::SUCCESS;
    }
}
