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

namespace Fidry\Console\Tests\IO;

use Composer\InstalledVersions;
use Composer\Semver\VersionParser;
use Fidry\Console\InputAssert;
use Fidry\Console\IO;
use Fidry\Console\Output\SymfonyStyledOutput;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;
use stdClass;
use Symfony\Component\Console\Completion\CompletionInput;
use Symfony\Component\Console\Exception\InvalidArgumentException as ConsoleInvalidArgumentException;
use Symfony\Component\Console\Input\ArgvInput;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputDefinition;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\StringInput;
use Symfony\Component\Console\Logger\ConsoleLogger;
use Symfony\Component\Console\Output\BufferedOutput;
use Symfony\Component\Console\Output\ConsoleOutput;
use Symfony\Component\Console\Output\NullOutput;
use TypeError;

#[CoversClass(InputAssert::class)]
#[CoversClass(IO::class)]
final class IOTest extends TestCase
{
    /**
     * The legacy group is due to InputInterface::getParameterOption().
     * @group legacy
     */
    public function test_it_exposes_its_input_and_output(): void
    {
        $input = new StringInput('');
        $output = new NullOutput();

        $io = new IO($input, $output);

        self::assertSame($input, $io->getInput());
        self::assertSame($output, $io->getOutput());
    }

    #[DataProvider('inputProvider')]
    public function test_it_exposes_if_its_input_is_interactive(
        InputInterface $input,
        bool $expectedInteractivity
    ): void {
        $output = new NullOutput();

        $io = new IO($input, $output);

        self::assertSame($expectedInteractivity, $io->isInteractive());
    }

    public static function inputProvider(): iterable
    {
        foreach ([true, false] as $interactive) {
            yield [
                self::createInput($interactive),
                $interactive,
            ];
        }
    }

    public function test_it_can_create_a_io_with_default_values_for_standard_usage(): void
    {
        $io = IO::createDefault();

        self::assertCount(0, $io->getInput()->getArguments());
        self::assertCount(0, $io->getInput()->getOptions());

        self::assertInstanceOf(ConsoleOutput::class, $io->getOutput());
    }

    public function test_it_can_create_a_null_io(): void
    {
        $io = IO::createNull();

        self::assertCount(0, $io->getInput()->getArguments());
        self::assertCount(0, $io->getInput()->getOptions());

        self::assertInstanceOf(NullOutput::class, $io->getOutput());
    }

    #[DataProvider('invalidArgumentTypeProvider')]
    public function test_it_checks_against_invalid_argument_default_types(
        mixed $default,
        string $expectedMessage
    ): void {
        try {
            $inputArgument = new InputArgument(
                'arg',
                InputArgument::OPTIONAL,
                '',
                $default,
            );
        } catch (TypeError $invalidDefaultValueType) {
            if (self::isSymfony6OrMore()) {
                // Symfony updated the Console component to have union types
                // solving the issue.
                /** @psalm-suppress InternalMethod */
                $this->addToAssertionCount(1);

                return;
            }
            self::throwException($invalidDefaultValueType);
        }

        self::assertTrue(isset($inputArgument));

        $io = new IO(
            new ArrayInput(
                [],
                new InputDefinition([$inputArgument]),
            ),
            new NullOutput(),
        );

        $this->expectException(ConsoleInvalidArgumentException::class);
        $this->expectExceptionMessage($expectedMessage);

        $io->getTypedArgument('arg')->asString();
    }

    public static function invalidArgumentTypeProvider(): iterable
    {
        yield from self::invalidScalarArgumentTypeProvider();
        yield from self::invalidArrayArgumentTypeProvider();
    }

    public static function invalidScalarArgumentTypeProvider(): iterable
    {
        yield 'boolean' => [
            false,
            'Expected an argument value type to be "null|string|list<string>". Got "bool" for the argument "arg".',
        ];

        yield 'int' => [
            10,
            'Expected an argument value type to be "null|string|list<string>". Got "int" for the argument "arg".',
        ];

        yield 'float' => [
            10.8,
            'Expected an argument value type to be "null|string|list<string>". Got "float" for the argument "arg".',
        ];

        yield 'object' => [
            new stdClass(),
            'Expected an argument value type to be "null|string|list<string>". Got "stdClass" for the argument "arg".',
        ];

        yield 'closure' => [
            static fn () => '',
            'Expected an argument value type to be "null|string|list<string>". Got "Closure" for the argument "arg".',
        ];
    }

    public static function invalidArrayArgumentTypeProvider(): iterable
    {
        foreach (self::invalidScalarArgumentTypeProvider() as [$item, $message]) {
            yield [[$item], $message];
        }
    }

    #[DataProvider('invalidOptionTypeProvider')]
    public function test_it_checks_against_invalid_option_default_types(
        mixed $default,
        string $expectedMessage
    ): void {
        try {
            $inputOption = new InputOption(
                'opt',
                null,
                InputOption::VALUE_OPTIONAL,
                '',
                $default,
            );
        } catch (TypeError $invalidDefaultValueType) {
            if (self::isSymfony6OrMore()) {
                // Symfony updated the Console component to have union types
                // solving the issue.
                /** @psalm-suppress InternalMethod */
                $this->addToAssertionCount(1);

                return;
            }
            self::throwException($invalidDefaultValueType);
        }

        self::assertTrue(isset($inputOption));

        $io = new IO(
            new ArrayInput(
                [],
                new InputDefinition([$inputOption]),
            ),
            new NullOutput(),
        );

        $this->expectException(ConsoleInvalidArgumentException::class);
        $this->expectExceptionMessage($expectedMessage);

        $io->getTypedOption('opt')->asString();
    }

    public function test_it_can_create_a_new_instance_with_a_new_input(): void
    {
        $input = new StringInput('');
        $output = new NullOutput();

        $io = new IO($input, $output);

        $newInput = new CompletionInput();

        $newIO = $io->withInput($newInput);

        self::assertSame($input, $io->getInput());
        self::assertSame($newInput, $newIO->getInput());

        self::assertSame($output, $io->getOutput());
        self::assertSame($io->getOutput(), $newIO->getOutput());
    }

    public function test_it_preserves_the_styled_output_when_creating_a_new_instance_with_a_new_input(): void
    {
        $input = new StringInput('');
        $newInput = new CompletionInput();
        $output = new NullOutput();

        $io = new IO(
            $input,
            $output,
            DummyStyledOutput::getFactory(),
        );
        $newIO = $io->withInput($newInput);

        self::assertInstanceOf(DummyStyledOutput::class, $io->getStyledOutput());   // Sanity check
        self::assertInstanceOf(DummyStyledOutput::class, $newIO->getStyledOutput());
    }

    public function test_it_preserves_the_logger_when_creating_a_new_instance_with_a_new_input(): void
    {
        $input = new StringInput('');
        $newInput = new CompletionInput();
        $output = new NullOutput();

        $io = new IO(
            $input,
            $output,
            null,
            DummyLogger::getFactory(),
        );
        $newIO = $io->withInput($newInput);

        self::assertInstanceOf(DummyLogger::class, $io->getLogger());   // Sanity check
        self::assertInstanceOf(DummyLogger::class, $newIO->getLogger());
    }

    public function test_it_can_create_a_new_instance_with_a_new_output(): void
    {
        $input = new StringInput('');
        $output = new NullOutput();

        $io = new IO($input, $output);

        $newOutput = new BufferedOutput();

        $newIO = $io->withOutput($newOutput);

        self::assertSame($input, $io->getInput());
        self::assertSame($output, $io->getOutput());

        self::assertSame($input, $newIO->getInput());
        self::assertSame($newOutput, $newIO->getOutput());
    }

    public function test_it_preserves_the_styled_output_when_creating_a_new_instance_with_a_new_output(): void
    {
        $input = new StringInput('');
        $output = new NullOutput();
        $newOutput = new NullOutput();

        $io = new IO(
            $input,
            $output,
            DummyStyledOutput::getFactory(),
        );
        $newIO = $io->withOutput($newOutput);

        self::assertInstanceOf(DummyStyledOutput::class, $io->getStyledOutput());   // Sanity check
        self::assertInstanceOf(DummyStyledOutput::class, $newIO->getStyledOutput());
    }

    public function test_it_preserves_the_logger_when_creating_a_new_instance_with_a_new_output(): void
    {
        $input = new StringInput('');
        $output = new NullOutput();
        $newOutput = new NullOutput();

        $io = new IO(
            $input,
            $output,
            null,
            DummyLogger::getFactory(),
        );
        $newIO = $io->withOutput($newOutput);

        self::assertInstanceOf(DummyLogger::class, $io->getLogger());   // Sanity check
        self::assertInstanceOf(DummyLogger::class, $newIO->getLogger());
    }

    /**
     * @param non-empty-string $option
     */
    #[DataProvider('optionProvider')]
    public function test_it_can_tell_if_an_option_is_present(
        InputInterface $input,
        string $option,
        bool $expected
    ): void {
        $io = new IO(
            $input,
            new NullOutput(),
        );

        $actual = $io->hasParameterOption($option);

        self::assertSame($expected, $actual);
    }

    /**
     * @param non-empty-string $option
     */
    #[DataProvider('optionWithOnlyOptionsProvider')]
    public function test_it_can_tell_if_an_option_with_only_real_params_is_present(
        InputInterface $input,
        string $option,
        bool $expected
    ): void {
        $io = new IO(
            $input,
            new NullOutput(),
        );

        $actual = $io->hasParameterOption($option, true);

        self::assertSame($expected, $actual);
    }

    public function test_it_does_not_check_real_params_by_default_when_checking_an_option_presence(): void
    {
        $io = new IO(
            new ArgvInput(['cli.php', '--', '--foo']),
            new NullOutput(),
        );

        $result = $io->hasParameterOption('--foo');

        self::assertTrue($result);
    }

    public static function invalidOptionTypeProvider(): iterable
    {
        yield from self::invalidScalarOptionTypeProvider();
        yield from self::invalidArrayOptionTypeProvider();
    }

    public static function invalidScalarOptionTypeProvider(): iterable
    {
        yield 'int' => [
            10,
            'Expected an option value type to be "null|bool|string|list<string>". Got "int" for the option "opt".',
        ];

        yield 'float' => [
            10.8,
            'Expected an option value type to be "null|bool|string|list<string>". Got "float" for the option "opt".',
        ];

        yield 'object' => [
            new stdClass(),
            'Expected an option value type to be "null|bool|string|list<string>". Got "stdClass" for the option "opt".',
        ];

        yield 'closure' => [
            static fn () => '',
            'Expected an option value type to be "null|bool|string|list<string>". Got "Closure" for the option "opt".',
        ];
    }

    public static function invalidArrayOptionTypeProvider(): iterable
    {
        foreach (self::invalidScalarOptionTypeProvider() as [$item, $message]) {
            yield [[$item], $message];
        }
    }

    public static function optionProvider(): iterable
    {
        $createLongOptionSet = static function (string $title, InputInterface $input): iterable {
            yield $title.' (present)' => [
                $input,
                '--opt',
                true,
            ];

            yield $title.' (missing)' => [
                $input,
                '--anotherOpt',
                false,
            ];
        };

        $createShortOptionSet = static function (string $title, InputInterface $input): iterable {
            yield $title.' (present)' => [
                $input,
                '-opt',
                true,
            ];

            yield $title.' (missing)' => [
                $input,
                '-anotherOpt',
                false,
            ];
        };

        yield from $createLongOptionSet(
            'long option with value after',
            new ArgvInput(['cli.php', '--opt', 'foo']),
        );

        yield from $createLongOptionSet(
            'long option without value after',
            new ArgvInput(['cli.php', '--opt']),
        );

        yield from $createLongOptionSet(
            'long option with value assigned after',
            new ArgvInput(['cli.php', '--opt=foo']),
        );

        yield from $createShortOptionSet(
            'short option with value after',
            new ArgvInput(['cli.php', '-opt', 'foo']),
        );

        yield from $createShortOptionSet(
            'short option without value after',
            new ArgvInput(['cli.php', '-opt']),
        );

        yield from $createShortOptionSet(
            'short option with value assigned after',
            new ArgvInput(['cli.php', '-opt=foo']),
        );
    }

    public static function optionWithOnlyOptionsProvider(): iterable
    {
        $createLongOptionSet = static function (string $title, InputInterface $input): iterable {
            yield $title.' (present)' => [
                $input,
                '--opt',
                true,
            ];

            yield $title.' (missing)' => [
                $input,
                '--anotherOpt',
                false,
            ];
        };

        $createShortOptionSet = static function (string $title, InputInterface $input): iterable {
            yield $title.' (present)' => [
                $input,
                '-opt',
                true,
            ];

            yield $title.' (missing)' => [
                $input,
                '-anotherOpt',
                false,
            ];
        };

        yield from $createLongOptionSet(
            'long option with value after',
            new ArgvInput(['cli.php', '--opt', 'foo', '--']),
        );

        yield '(non real param) long option with value after' => [
            new ArgvInput(['cli.php', '--', '--opt', 'foo']),
            '--opt',
            false,
        ];

        yield from $createLongOptionSet(
            'long option without value after',
            new ArgvInput(['cli.php', '--opt']),
        );

        yield '(non real param) long option without value after' => [
            new ArgvInput(['cli.php', '--', '--opt']),
            '--opt',
            false,
        ];

        yield from $createLongOptionSet(
            'long option with value assigned after',
            new ArgvInput(['cli.php', '--opt=foo']),
        );

        yield '(non real param) long option with value assigned after' => [
            new ArgvInput(['cli.php', '--', '--opt=foo']),
            '--opt',
            false,
        ];

        yield from $createShortOptionSet(
            'short option with value after',
            new ArgvInput(['cli.php', '-opt', 'foo']),
        );

        yield '(non real param) short option with value after' => [
            new ArgvInput(['cli.php', '--', '-opt', 'foo']),
            '-opt',
            false,
        ];

        yield from $createShortOptionSet(
            'short option without value after',
            new ArgvInput(['cli.php', '-opt']),
        );

        yield '(non real param) short option without value after' => [
            new ArgvInput(['cli.php', '--', '-opt']),
            '-opt',
            false,
        ];

        yield from $createShortOptionSet(
            'short option with value assigned after',
            new ArgvInput(['cli.php', '-opt=foo']),
        );

        yield '(non real param) short option with value assigned after' => [
            new ArgvInput(['cli.php', '--', '-opt=foo']),
            '-opt',
            false,
        ];
    }

    public function test_it_can_be_created_with_a_custom_style(): void
    {
        $io = new IO(
            new StringInput(''),
            new NullOutput(),
            DummyStyledOutput::getFactory(),
        );

        self::assertInstanceOf(DummyStyledOutput::class, $io->getStyledOutput());
        self::assertInstanceOf(DummyStyledOutput::class, $io->getStyledErrorOutput());
    }

    public function test_it_can_get_the_error_io_with_an_output_that_does_not_have_an_error_output(): void
    {
        $input = new StringInput('');
        $output = new NullOutput();

        $io = new IO($input, $output);
        $errorIO = $io->getErrorIO();

        // Sanity check
        self::assertSame($input, $io->getInput());
        self::assertSame($output, $io->getOutput());

        self::assertSame($input, $errorIO->getInput());
        self::assertSame($output, $errorIO->getOutput());
    }

    public function test_it_can_get_the_error_io_with_an_output_that_has_an_error_output(): void
    {
        $input = new StringInput('');
        $output = new NullOutput();
        $errorOutput = new NullOutput();
        $consoleOutput = new DummyConsoleOutput($output, $errorOutput);

        $io = new IO($input, $consoleOutput);
        $errorIO = $io->getErrorIO();

        // Sanity check
        self::assertSame($input, $io->getInput());
        self::assertSame($consoleOutput, $io->getOutput());

        self::assertSame($input, $errorIO->getInput());
        self::assertSame($errorOutput, $errorIO->getOutput());
    }

    public function test_it_transfers_its_state_to_the_error_output(): void
    {
        $input = new StringInput('');
        $output = new NullOutput();

        $io = new IO(
            $input,
            $output,
            DummyStyledOutput::getFactory(),
            DummyLogger::getFactory(),
        );
        $errorIO = $io->getErrorIO();

        self::assertInstanceOf(DummyStyledOutput::class, $io->getStyledOutput());   // Sanity check
        self::assertInstanceOf(DummyStyledOutput::class, $errorIO->getStyledOutput());

        self::assertInstanceOf(DummyLogger::class, $io->getLogger());   // Sanity check
        self::assertInstanceOf(DummyLogger::class, $errorIO->getLogger());
    }

    public function test_it_preserves_its_state_when_creating_with_a_different_logger(): void
    {
        $io = new IO(
            new StringInput(''),
            new NullOutput(),
            DummyStyledOutput::getFactory(),
        );
        $newIO = $io->withLoggerFactory(DummyLogger::getFactory());

        self::assertInstanceOf(DummyStyledOutput::class, $io->getStyledOutput());
        self::assertInstanceOf(DummyStyledOutput::class, $newIO->getStyledOutput());
    }

    public function test_it_preserves_its_state_when_creating_an_io_with_a_custom_styled_output(): void
    {
        $io = new IO(
            new StringInput(''),
            new NullOutput(),
            null,
            DummyLogger::getFactory(),
        );
        $newIO = $io->withStyledOutputFactory(DummyStyledOutput::getFactory());

        self::assertInstanceOf(DummyLogger::class, $io->getLogger());
        self::assertInstanceOf(DummyLogger::class, $newIO->getLogger());
    }

    public function test_it_exposes_its_error_output(): void
    {
        $errorOutput = new NullOutput();
        $output = new DummyConsoleOutput(new NullOutput(), $errorOutput);

        $io = new IO(
            new StringInput(''),
            $output,
        );

        self::assertSame($errorOutput, $io->getErrorOutput());
    }

    public function test_it_exposes_the_regular_output_as_its_error_output_if_the_output_has_no_error_output(): void
    {
        $output = new NullOutput();

        $io = new IO(
            new StringInput(''),
            $output,
        );

        self::assertSame($output, $io->getErrorOutput());
    }

    public function test_it_can_create_another_io_with_a_different_styled_output(): void
    {
        $io = IO::createNull();
        $newIO = $io->withStyledOutputFactory(DummyStyledOutput::getFactory());

        self::assertInstanceOf(SymfonyStyledOutput::class, $io->getStyledOutput()); // Sanity check
        self::assertInstanceOf(DummyStyledOutput::class, $newIO->getStyledOutput());
    }

    public function test_it_can_create_another_io_with_the_default_styled_output(): void
    {
        $io = new IO(
            new StringInput(''),
            new NullOutput(),
            DummyStyledOutput::getFactory(),
        );
        $newIO = $io->withStyledOutputFactory(null);

        self::assertInstanceOf(DummyStyledOutput::class, $io->getStyledOutput()); // Sanity check
        self::assertInstanceOf(SymfonyStyledOutput::class, $newIO->getStyledOutput());
    }

    public function test_it_can_get_the_styled_error_output(): void
    {
        $errorOutput = new BufferedOutput();
        $output = new DummyConsoleOutput(new NullOutput(), $errorOutput);

        $io = new IO(
            new StringInput(''),
            $output,
        );

        $io->getStyledErrorOutput()->error('something happened.');

        self::assertNotSame('', $errorOutput->fetch());
    }

    public function test_it_can_be_created_with_a_logger(): void
    {
        $io = new IO(
            new StringInput(''),
            new NullOutput(),
            null,
            DummyLogger::getFactory(),
        );

        self::assertInstanceOf(DummyLogger::class, $io->getLogger());
        self::assertInstanceOf(DummyLogger::class, $io->getErrorLogger());
    }

    public function test_it_can_create_another_io_with_a_different_logger(): void
    {
        $io = IO::createNull();
        $newIO = $io->withLoggerFactory(DummyLogger::getFactory());

        self::assertInstanceOf(ConsoleLogger::class, $io->getLogger()); // Sanity check
        self::assertInstanceOf(DummyLogger::class, $newIO->getLogger());
        self::assertInstanceOf(DummyLogger::class, $newIO->getErrorLogger());
    }

    public function test_it_can_create_another_io_with_the_default_logger(): void
    {
        $io = new IO(
            new StringInput(''),
            new NullOutput(),
            null,
            DummyLogger::getFactory(),
        );
        $newIO = $io->withLoggerFactory(null);

        // Sanity check
        self::assertInstanceOf(DummyLogger::class, $io->getLogger());
        self::assertInstanceOf(DummyLogger::class, $io->getErrorLogger());

        self::assertInstanceOf(ConsoleLogger::class, $newIO->getLogger());
        self::assertInstanceOf(ConsoleLogger::class, $newIO->getErrorLogger());
    }

    public function test_it_can_get_log_to_the_output_via_the_logger(): void
    {
        $stdout = new BufferedOutput();
        $output = new DummyConsoleOutput($stdout, new NullOutput());

        $io = new IO(
            new StringInput(''),
            $output,
        );

        $io->getLogger()->warning('something happened.');

        self::assertNotSame('', $stdout->fetch());
    }

    public function test_it_can_get_log_to_the_output_directly(): void
    {
        $stdout = new BufferedOutput();
        $output = new DummyConsoleOutput($stdout, new NullOutput());

        $io = new IO(
            new StringInput(''),
            $output,
        );

        $io->logWarning('something happened.');

        self::assertNotSame('', $stdout->fetch());
    }

    public function test_it_can_get_log_to_the_error_output_via_the_logger(): void
    {
        $errorOutput = new BufferedOutput();
        $output = new DummyConsoleOutput(new NullOutput(), $errorOutput);

        $io = new IO(
            new StringInput(''),
            $output,
        );

        $io->getErrorLogger()->warning('something happened.');

        self::assertNotSame('', $errorOutput->fetch());
    }

    public function test_it_can_get_log_to_the_error_output_directly(): void
    {
        $errorOutput = new BufferedOutput();
        $output = new DummyConsoleOutput(new NullOutput(), $errorOutput);

        $io = new IO(
            new StringInput(''),
            $output,
        );

        $io->getErrorIO()->logWarning('something happened.');

        self::assertNotSame('', $errorOutput->fetch());
    }

    private static function createInput(bool $interactive): InputInterface
    {
        $input = new StringInput('');
        $input->setInteractive($interactive);

        return $input;
    }

    private static function isSymfony6OrMore(): bool
    {
        static $result;

        if (isset($result)) {
            return $result;
        }

        $result = InstalledVersions::satisfies(
            new VersionParser(),
            'symfony/console',
            '6.*',
        );

        return $result;
    }
}
