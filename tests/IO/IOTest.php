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
use Fidry\Console\Input\IO;
use PHPUnit\Framework\TestCase;
use stdClass;
use Symfony\Component\Console\Completion\CompletionInput;
use Symfony\Component\Console\Exception\InvalidArgumentException as ConsoleInvalidArgumentException;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputDefinition;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\StringInput;
use Symfony\Component\Console\Output\BufferedOutput;
use Symfony\Component\Console\Output\NullOutput;
use TypeError;

/**
 * @covers \Fidry\Console\Input\IO
 * @covers \Fidry\Console\InputAssert
 */
final class IOTest extends TestCase
{
    public function test_it_exposes_its_input_and_output(): void
    {
        $input = new StringInput('');
        $output = new NullOutput();

        $io = new IO($input, $output);

        self::assertSame($input, $io->getInput());
        self::assertSame($output, $io->getOutput());
    }

    /**
     * @dataProvider inputProvider
     */
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

    public function test_it_can_create_a_null_io(): void
    {
        $io = IO::createNull();

        self::assertCount(0, $io->getInput()->getArguments());
        self::assertCount(0, $io->getInput()->getOptions());

        self::assertInstanceOf(NullOutput::class, $io->getOutput());
    }

    /**
     * @dataProvider invalidArgumentTypeProvider
     *
     * @param mixed $default
     */
    public function test_it_checks_against_invalid_argument_default_types(
        $default,
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

        /** @psalm-suppress DeprecatedMethod */
        $io->getStringArgument('arg');
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
            'Expected an argument value type to be "null|string|list<string>". Got "bool"',
        ];

        yield 'int' => [
            10,
            'Expected an argument value type to be "null|string|list<string>". Got "int"',
        ];

        yield 'float' => [
            10.8,
            'Expected an argument value type to be "null|string|list<string>". Got "float"',
        ];

        yield 'object' => [
            new stdClass(),
            'Expected an argument value type to be "null|string|list<string>". Got "stdClass"',
        ];

        yield 'closure' => [
            static fn () => '',
            'Expected an argument value type to be "null|string|list<string>". Got "Closure"',
        ];
    }

    public static function invalidArrayArgumentTypeProvider(): iterable
    {
        foreach (self::invalidScalarArgumentTypeProvider() as [$item, $message]) {
            yield [[$item], $message];
        }
    }

    /**
     * @dataProvider invalidOptionTypeProvider
     *
     * @param mixed $default
     */
    public function test_it_checks_against_invalid_option_default_types(
        $default,
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

        $io->getOption('opt')->asString();
    }

    public function test_it_can_create_a_new_instance_with_a_new_input(): void
    {
        $input = new StringInput('');
        $output = new NullOutput();

        $io = new IO($input, $output);

        $newInput = new CompletionInput();

        $newIO = $io->withInput($newInput);

        self::assertSame($input, $io->getInput());
        self::assertSame($output, $io->getOutput());

        self::assertSame($newInput, $newIO->getInput());
        self::assertSame($output, $newIO->getOutput());
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

    public static function invalidOptionTypeProvider(): iterable
    {
        yield from self::invalidScalarOptionTypeProvider();
        yield from self::invalidArrayOptionTypeProvider();
    }

    public static function invalidScalarOptionTypeProvider(): iterable
    {
        yield 'int' => [
            10,
            'Expected an option value type to be "null|bool|string|list<string>". Got "int"',
        ];

        yield 'float' => [
            10.8,
            'Expected an option value type to be "null|bool|string|list<string>". Got "float"',
        ];

        yield 'object' => [
            new stdClass(),
            'Expected an option value type to be "null|bool|string|list<string>". Got "stdClass"',
        ];

        yield 'closure' => [
            static fn () => '',
            'Expected an option value type to be "null|bool|string|list<string>". Got "Closure"',
        ];
    }

    public static function invalidArrayOptionTypeProvider(): iterable
    {
        foreach (self::invalidScalarOptionTypeProvider() as [$item, $message]) {
            yield [[$item], $message];
        }
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
