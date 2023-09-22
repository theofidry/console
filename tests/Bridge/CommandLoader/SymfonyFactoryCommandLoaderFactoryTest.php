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

namespace Fidry\Console\Tests\Bridge\CommandLoader;

use Fidry\Console\Bridge\Command\BasicSymfonyCommandFactory;
use Fidry\Console\Bridge\CommandLoader\CommandLoaderFactory;
use Fidry\Console\Bridge\CommandLoader\SymfonyFactoryCommandLoaderFactory;
use Fidry\Console\Command\LazyCommandEnvelope;
use Fidry\Console\Tests\Command\Fixture\SimpleCommand;
use Fidry\Console\Tests\Command\Fixture\SimpleLazyCommand;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

/**
 * @covers \Fidry\Console\Bridge\CommandLoader\SymfonyFactoryCommandLoaderFactory
 */
final class SymfonyFactoryCommandLoaderFactoryTest extends TestCase
{
    private CommandLoaderFactory $factory;

    protected function setUp(): void
    {
        $this->factory = new SymfonyFactoryCommandLoaderFactory(
            new BasicSymfonyCommandFactory(),
        );
    }

    #[DataProvider('commandProvider')]
    public function test_it_creates_a_symfony_command_loader_for_the_given_commands(
        array $commands,
        array $expected,
    ): void {
        $actual = $this->factory->createCommandLoader($commands)->getNames();

        self::assertSame($expected, $actual);
    }

    public static function commandProvider(): iterable
    {
        yield [
            [
                new SimpleCommand(),
                new LazyCommandEnvelope(
                    'app:lazy:foo',
                    'Lazy',
                    static fn () => new SimpleCommand(),
                ),
                LazyCommandEnvelope::wrap(
                    SimpleLazyCommand::class,
                    static fn () => new SimpleLazyCommand(static function (): void {}),
                ),
            ],
            [
                'app:foo',
                'app:lazy:foo',
                'app:lazy',
            ],
        ];
    }
}
