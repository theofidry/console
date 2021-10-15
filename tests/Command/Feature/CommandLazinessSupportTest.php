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

namespace Fidry\Console\Tests\Command\Feature;

use Fidry\Console\ExitCode;
use Fidry\Console\Tests\StatefulService;
use Symfony\Bundle\FrameworkBundle\Console\Application;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\Console\Input\StringInput;
use Symfony\Component\Console\Output\BufferedOutput;
use Symfony\Component\Console\Output\NullOutput;
use Symfony\Component\Console\Tester\CommandTester;

/**
 * @covers \Fidry\Console\Command\SymfonyCommand
 */
final class CommandLazinessSupportTest extends KernelTestCase
{
    private StatefulService $service;
    private Application $application;

    protected function setUp(): void
    {
        self::bootKernel();

        $this->service = self::$kernel->getContainer()->get(StatefulService::class);

        $this->application = new Application(self::$kernel);
        $this->application->setAutoExit(false);
        $this->application->setCatchExceptions(false);
    }

    public function test_it_is_not_instantiated_by_the_application_finder(): void
    {
        // Sanity check
        self::assertFalse($this->service->called);

        // Sanity check; Finding another command – if command is not lazy it
        // will be loaded
        $this->application->find('app:foo');

        /** @psalm-suppress RedundantConditionGivenDocblockType */
        self::assertFalse($this->service->called);

        $this->application->find('app:lazy');

        /** @psalm-suppress RedundantConditionGivenDocblockType */
        self::assertFalse($this->service->called);
    }

    public function test_it_is_not_instantiated_by_the_list_command(): void
    {
        $input = new StringInput('list');
        $output = new BufferedOutput();

        // Sanity check
        self::assertFalse($this->service->called);

        $this->application->run($input, $output);

        /** @psalm-suppress RedundantConditionGivenDocblockType */
        self::assertFalse($this->service->called);
    }

    public function test_it_is_instantiated_when_getting_a_non_lazy_defining_property(): void
    {
        // Sanity check
        self::assertFalse($this->service->called);

        $this->application->find('app:lazy')->getSynopsis();

        /** @psalm-suppress DocblockTypeContradiction */
        self::assertTrue($this->service->called);
    }

    public function test_it_can_be_executed_via_the_command_tester(): void
    {
        // Sanity check
        self::assertFalse($this->service->called);

        $command = $this->application->find('app:lazy');
        $tester = new CommandTester($command);

        $tester->execute([], ['interactive' => false]);

        /** @psalm-suppress DocblockTypeContradiction */
        self::assertTrue($this->service->called);
    }

    public function test_it_can_be_executed_via_the_application(): void
    {
        // Sanity check
        self::assertFalse($this->service->called);

        $input = new StringInput('app:lazy');
        $input->setInteractive(false);

        $exitCode = $this->application->run(
            $input,
            new NullOutput(),
        );

        self::assertSame(ExitCode::SUCCESS, $exitCode);

        /** @psalm-suppress DocblockTypeContradiction */
        self::assertTrue($this->service->called);
    }
}
