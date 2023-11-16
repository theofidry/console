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
use Fidry\Console\Bridge\Application\SymfonyApplication;
use Fidry\Console\Command\SymfonyCommand;
use Fidry\Console\Tests\Application\Fixture\ApplicationWithReversedCommand;
use Fidry\Console\Tests\Application\OutputAssertions;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Console\Input\StringInput;
use Symfony\Component\Console\Output\BufferedOutput;

#[CoversClass(ApplicationRunner::class)]
#[CoversClass(SymfonyApplication::class)]
#[CoversClass(SymfonyCommand::class)]
final class ApplicationReversedCommandsSupportTest extends TestCase
{
    public function test_it_can_execute_the_symfony_command(): void
    {
        $input = new StringInput('symfony-cmd');
        $output = new BufferedOutput();

        ApplicationRunner::runApplication(
            new ApplicationWithReversedCommand(),
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
