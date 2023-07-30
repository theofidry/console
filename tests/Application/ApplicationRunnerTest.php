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

namespace Fidry\Console\Tests\Application;

use DomainException;
use Fidry\Console\Application\ApplicationRunner;
use Fidry\Console\Tests\Bridge\Command\FakeSymfonyCommandLoaderFactory;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(ApplicationRunner::class)]
final class ApplicationRunnerTest extends TestCase
{
    public function test_it_uses_the_command_factory_given(): void
    {
        $runner = new ApplicationRunner(
            new DummyApplication(),
            new FakeSymfonyCommandLoaderFactory(),
        );

        $this->expectException(DomainException::class);
        $this->expectExceptionMessage('Should not be called.');

        $runner->run();
    }
}
