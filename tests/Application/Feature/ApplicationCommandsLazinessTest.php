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

use Closure;
use DomainException;
use Fidry\Console\Application\ApplicationRunner;
use Fidry\Console\Application\BaseApplication;
use Fidry\Console\Bridge\Application\SymfonyApplication;
use Fidry\Console\Command\Command;
use Fidry\Console\Tests\Application\Fixture\ConfigurableCommandsApplication;
use Fidry\Console\Tests\Application\Fixture\ManualLazyCommand;
use Fidry\Console\Tests\Application\OutputAssertions;
use Fidry\Console\Tests\Command\Fixture\FakeCommand;
use Fidry\Console\Tests\Command\Fixture\SimpleCommand;
use Fidry\Console\Tests\Command\Fixture\SimpleLazyCommand;
use PHPUnit\Exception as PHPUnitException;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Console\Input\Input;
use Symfony\Component\Console\Input\StringInput;
use Symfony\Component\Console\Output\BufferedOutput;
use Throwable;

#[CoversClass(ApplicationRunner::class)]
#[CoversClass(BaseApplication::class)]
#[CoversClass(SymfonyApplication::class)]
final class ApplicationCommandsLazinessTest extends TestCase
{
    private const EXPECTED_LIST_OUTPUT_64 = <<<'EOT'
        help message

        Usage:
          command [options] [arguments]

        Options:
          -h, --help            Display help for the given command. When no command is given display help for the app:foo command
          -q, --quiet           Do not output any message
          -V, --version         Display this application version
              --ansi|--no-ansi  Force (or disable --no-ansi) ANSI output
          -n, --no-interaction  Do not ask any interactive question
          -v|vv|vvv, --verbose  Increase the verbosity of messages: 1 for normal output, 2 for more verbose output and 3 for debug

        Available commands:
          completion    Dump the shell completion script
          help          Display help for a command
          list          List commands
         app
          app:lazy-foo  Lazy foo description

        EOT;

    private const EXPECTED_LIST_OUTPUT_72_OR_HIGHER = <<<'EOT'
        help message

        Usage:
          command [options] [arguments]

        Options:
          -h, --help            Display help for the given command. When no command is given display help for the app:foo command
              --silent          Do not output any message
          -q, --quiet           Only errors are displayed. All other output is suppressed
          -V, --version         Display this application version
              --ansi|--no-ansi  Force (or disable --no-ansi) ANSI output
          -n, --no-interaction  Do not ask any interactive question
          -v|vv|vvv, --verbose  Increase the verbosity of messages: 1 for normal output, 2 for more verbose output and 3 for debug

        Available commands:
          completion    Dump the shell completion script
          help          Display help for a command
          list          List commands
         app
          app:lazy-foo  Lazy foo description

        EOT;

    /**
     * @param Closure(): Command[] $commandsFactory
     */
    #[DataProvider('commandProvider')]
    public function test_it_can_be_run(
        Input $input,
        Closure $commandsFactory,
        string|Throwable $expectedOutput,
    ): void {
        $output = new BufferedOutput();
        $application = new ConfigurableCommandsApplication($commandsFactory);

        try {
            ApplicationRunner::runApplication(
                $application,
                $input,
                $output,
            );

            $this->failIfExpectedThrowableToBeThrown($expectedOutput);
        } catch (PHPUnitException $phpunitException) {
            throw $phpunitException;
        } catch (Throwable $commandCouldNotBeExecuted) {
            if ($expectedOutput instanceof Throwable) {
                self::assertSameClassAndMessage(
                    $expectedOutput,
                    $commandCouldNotBeExecuted,
                );

                return;
            }

            throw $commandCouldNotBeExecuted;
        }

        OutputAssertions::assertSameOutput(
            $expectedOutput,
            $output->fetch(),
        );
    }

    public static function commandProvider(): iterable
    {
        // The laziness of a command can be defined as follows:
        // - Not lazy: it will be instantiated immediately as soon as the application is instantiated.
        // - Soft lazy: it will not be instantiated when the application is instantiated, neither when executing
        //   another command. However, the list command for example will instantiate it.
        // - (Truly) lazy: it will not be instantiated when the application is instantiated or by another command except
        //   when running the (lazy) command itself.
        $exception = new DomainException();

        yield 'a LazyCommand can be made into a truly lazy command' => [
            new StringInput('list'),
            static fn () => [
                new ManualLazyCommand(
                    static fn () => new FakeCommand(),
                ),
            ],
            self::getExpectedListOutput(),
        ];

        // A LazyCommand by itself is not lazy
        yield 'LazyCommand; executing another command' => [
            new StringInput('app:foo'),
            static fn () => [
                new SimpleCommand(),
                new SimpleLazyCommand(
                    static fn () => throw $exception,
                ),
            ],
            $exception,
        ];

        yield 'LazyCommand; executing the list command' => [
            new StringInput('list'),
            static fn () => [
                new SimpleCommand(),
                new SimpleLazyCommand(
                    static fn () => throw $exception,
                ),
            ],
            $exception,
        ];
    }

    /**
     * @psalm-assert string $expected
     */
    private function failIfExpectedThrowableToBeThrown(mixed $expected): void
    {
        if ($expected instanceof Throwable) {
            self::fail(
                sprintf(
                    'Expected the following exception to be thrown: %s "%s". But none were thrown.',
                    $expected::class,
                    $expected->getMessage(),
                ),
            );
        }
    }

    private static function assertSameClassAndMessage(
        Throwable $expected,
        Throwable $actual,
    ): void {
        self::assertSame(
            $expected::class,
            $actual::class,
        );
        self::assertSame(
            $expected->getMessage(),
            $actual->getMessage(),
        );
    }

    private static function getExpectedListOutput(): string
    {
        return SymfonyVersion::isSfConsole72OrHigher()
            ? self::EXPECTED_LIST_OUTPUT_72_OR_HIGHER
            : self::EXPECTED_LIST_OUTPUT_64;
    }
}
