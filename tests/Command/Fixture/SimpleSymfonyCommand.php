<?php

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