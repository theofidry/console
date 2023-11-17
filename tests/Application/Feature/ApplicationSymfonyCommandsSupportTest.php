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

namespace Fidry\Console\Tests\Application\Feature;

use Fidry\Console\Application\ApplicationRunner;
use Fidry\Console\Tests\Application\Fixture\ApplicationWithSymfonyCommand;
use Fidry\Console\Tests\Application\OutputAssertions;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Console\Input\StringInput;
use Symfony\Component\Console\Output\BufferedOutput;

final class ApplicationSymfonyCommandsSupportTest extends TestCase
{
    public function test_it_can_execute_the_symfony_command(): void
    {
        $input = new StringInput('symfony-cmd');
        $output = new BufferedOutput();

        ApplicationRunner::runApplication(
            new ApplicationWithSymfonyCommand(),
            $input,
            $output,
        );

        $actual = $output->fetch();

        OutputAssertions::assertSameOutput(
            '',
            $actual,
        );
    }
}
