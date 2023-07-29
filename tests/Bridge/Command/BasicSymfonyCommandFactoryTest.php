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

namespace Fidry\Console\Tests\Bridge\Command;

use Fidry\Console\Bridge\Command\BasicSymfonyCommandFactory;
use Fidry\Console\Bridge\Command\SymfonyCommand as SymfonyBridgeCommand;
use Fidry\Console\Command\Command as FidryCommand;
use Fidry\Console\Tests\Command\Fixture\SimpleCommand;
use Fidry\Console\Tests\Command\Fixture\SimpleLazyCommand;
use Fidry\Console\Tests\StatefulService;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Console\Command\Command as SymfonyCommand;
use Symfony\Component\Console\Command\LazyCommand as SymfonyLazyCommand;

#[CoversClass(BasicSymfonyCommandFactory::class)]
final class BasicSymfonyCommandFactoryTest extends TestCase
{
    #[DataProvider('commandProvider')]
    public function test_it_can_create_a_symfony_command_from_a_fidry_command(
        FidryCommand $command,
        SymfonyCommand $expected,
    ): void {
        $actual = (new BasicSymfonyCommandFactory())->crateSymfonyCommand($command);

        self::assertEquals($expected, $actual);
    }

    public static function commandProvider(): iterable
    {
        yield 'standard command' => [
            new SimpleCommand(),
            new SymfonyBridgeCommand(
                new SimpleCommand(),
            ),
        ];

        yield 'lazy command' => [
            new SimpleLazyCommand(static fn () => new StatefulService()),
            new SymfonyLazyCommand(
                'app:lazy',
                [],
                'lazy command description',
                false,
                static fn () => new SymfonyBridgeCommand(
                    new SimpleLazyCommand(static fn () => new StatefulService()),
                ),
                true,
            ),
        ];
    }
}
