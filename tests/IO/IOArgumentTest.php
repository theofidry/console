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

use Fidry\Console\Input\IO;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Console\Application;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\StringInput;
use Symfony\Component\Console\Output\NullOutput;

/**
 * @covers \Fidry\Console\Input\IO
 * @covers \Fidry\Console\InputAssert
 */
final class IOArgumentTest extends TestCase
{
    private const ARGUMENT_NAME = 'arg';

    /**
     * @dataProvider argumentProvider
     */
    public function test_it_exposes_a_typed_api(
        InputArgument $inputArgument,
        string $argument,
        TypedInput $expected,
    ): void {
        $io = $this->getIO($inputArgument, $argument);

        TypeAssertions::assertExpectedArgumentTypes(
            $expected,
            $io,
            self::ARGUMENT_NAME,
        );
    }

    public static function argumentProvider(): iterable
    {
        foreach (self::requiredArgumentProvider() as $title => $set) {
            yield '[required] '.$title => $set;
        }

        foreach (self::optionalArgumentProvider() as $title => $set) {
            yield '[optional] '.$title => $set;
        }

        foreach (self::arrayArgumentProvider() as $title => $set) {
            yield '[array] '.$title => $set;
        }
    }

    public static function requiredArgumentProvider(): iterable
    {
        $mode = InputArgument::REQUIRED;

        yield 'empty string' => [
            new InputArgument(
                self::ARGUMENT_NAME,
                $mode,
                '',
                null,
            ),
            '""',
            TypedInput::createForScalar(
                new TypeException('Cannot cast a non-array input argument into an array. Got "\'\'"'),
                false,
                false,
                '',
                '',
                new TypeException('Expected an integer string. Got "\'\'"'),
                new TypeException('Expected an integer string. Got "\'\'"'),
                new TypeException('Expected a numeric string. Got "\'\'"'),
                new TypeException('Expected a numeric string. Got "\'\'"'),
            ),
        ];

        yield 'blank string' => [
            new InputArgument(
                self::ARGUMENT_NAME,
                $mode,
                '',
                null,
            ),
            '" "',
            TypedInput::createForScalar(
                new TypeException('Cannot cast a non-array input argument into an array. Got "\' \'"'),
                true,
                true,
                '',
                '',
                new TypeException('Expected an integer string. Got "\' \'"'),
                new TypeException('Expected an integer string. Got "\' \'"'),
                new TypeException('Expected a numeric string. Got "\' \'"'),
                new TypeException('Expected a numeric string. Got "\' \'"'),
            ),
        ];

        yield 'nominal string' => [
            new InputArgument(
                self::ARGUMENT_NAME,
                $mode,
                '',
                null,
            ),
            'foo',
            TypedInput::createForScalar(
                new TypeException('Cannot cast a non-array input argument into an array. Got "\'foo\'"'),
                true,
                true,
                'foo',
                'foo',
                new TypeException('Expected an integer string. Got "\'foo\'"'),
                new TypeException('Expected an integer string. Got "\'foo\'"'),
                new TypeException('Expected a numeric string. Got "\'foo\'"'),
                new TypeException('Expected a numeric string. Got "\'foo\'"'),
            ),
        ];

        yield 'string with spaces' => [
            new InputArgument(
                self::ARGUMENT_NAME,
                $mode,
                '',
                null,
            ),
            '" foo "',
            TypedInput::createForScalar(
                new TypeException('Cannot cast a non-array input argument into an array. Got "\' foo \'"'),
                true,
                true,
                'foo',
                'foo',
                new TypeException('Expected an integer string. Got "\' foo \'"'),
                new TypeException('Expected an integer string. Got "\' foo \'"'),
                new TypeException('Expected a numeric string. Got "\' foo \'"'),
                new TypeException('Expected a numeric string. Got "\' foo \'"'),
            ),
        ];

        yield 'null string' => [
            new InputArgument(
                self::ARGUMENT_NAME,
                $mode,
                '',
                null,
            ),
            'null',
            TypedInput::createForScalar(
                new TypeException('Cannot cast a non-array input argument into an array. Got "\'null\'"'),
                true,
                true,
                'null',
                'null',
                new TypeException('Expected an integer string. Got "\'null\'"'),
                new TypeException('Expected an integer string. Got "\'null\'"'),
                new TypeException('Expected a numeric string. Got "\'null\'"'),
                new TypeException('Expected a numeric string. Got "\'null\'"'),
            ),
        ];

        yield 'integer string' => [
            new InputArgument(
                self::ARGUMENT_NAME,
                $mode,
                '',
                null,
            ),
            '10',
            TypedInput::createForScalar(
                new TypeException('Cannot cast a non-array input argument into an array. Got "\'10\'"'),
                true,
                true,
                '10',
                '10',
                10,
                10,
                10.,
                10.,
            ),
        ];

        // negative integer string case: skipped see https://github.com/symfony/symfony/issues/27333

        yield 'zero integer string' => [
            new InputArgument(
                self::ARGUMENT_NAME,
                $mode,
                '',
                null,
            ),
            '0',
            TypedInput::createForScalar(
                new TypeException('Cannot cast a non-array input argument into an array. Got "\'0\'"'),
                false,
                false,
                '0',
                '0',
                0,
                0,
                0.,
                0.,
            ),
        ];

        yield 'float string' => [
            new InputArgument(
                self::ARGUMENT_NAME,
                $mode,
                '',
                null,
            ),
            '10.8',
            TypedInput::createForScalar(
                new TypeException('Cannot cast a non-array input argument into an array. Got "\'10.8\'"'),
                true,
                true,
                '10.8',
                '10.8',
                new TypeException('Expected an integer string. Got "\'10.8\'"'),
                new TypeException('Expected an integer string. Got "\'10.8\'"'),
                10.8,
                10.8,
            ),
        ];

        // negative float string case: skipped see https://github.com/symfony/symfony/issues/27333

        yield 'zero float string' => [
            new InputArgument(
                self::ARGUMENT_NAME,
                $mode,
                '',
                null,
            ),
            '0.',
            TypedInput::createForScalar(
                new TypeException('Cannot cast a non-array input argument into an array. Got "\'0.\'"'),
                true,
                true,
                '0.',
                '0.',
                new TypeException('Expected an integer string. Got "\'0.\'"'),
                new TypeException('Expected an integer string. Got "\'0.\'"'),
                0.,
                0.,
            ),
        ];
    }

    public static function optionalArgumentProvider(): iterable
    {
        yield 'no argument' => [
            new InputArgument(
                self::ARGUMENT_NAME,
                InputArgument::OPTIONAL,
                '',
                null,
            ),
            '',
            TypedInput::createForScalar(
                new TypeException('Cannot cast a non-array input argument into an array. Got "NULL"'),
                false,
                null,
                new TypeException('Expected a string. Got "NULL"'),
                null,
                new TypeException('Expected an integer string. Got "NULL"'),
                null,
                new TypeException('Expected a numeric string. Got "NULL"'),
                null,
            ),
        ];
    }

    public static function arrayArgumentProvider(): iterable
    {
        $mode = InputArgument::IS_ARRAY;

        yield 'empty string' => [
            new InputArgument(
                self::ARGUMENT_NAME,
                $mode,
                '',
                null,
            ),
            '""',
            TypedInput::createForArray(
                new TypeException(
                    <<<'TXT'
                    Expected a null or scalar value. Got the value: "array (
                      0 => '',
                    )"
                    TXT,
                ),
                [''],
                new TypeException('Expected an integer string. Got "\'\'"'),
                new TypeException('Expected a numeric string. Got "\'\'"'),
            ),
        ];

        yield 'single element string' => [
            new InputArgument(
                self::ARGUMENT_NAME,
                $mode,
                '',
                null,
            ),
            'foo',
            TypedInput::createForArray(
                new TypeException(
                    <<<'TXT'
                    Expected a null or scalar value. Got the value: "array (
                      0 => 'foo',
                    )"
                    TXT,
                ),
                ['foo'],
                new TypeException('Expected an integer string. Got "\'foo\'"'),
                new TypeException('Expected a numeric string. Got "\'foo\'"'),
            ),
        ];

        yield 'multiple elements string' => [
            new InputArgument(
                self::ARGUMENT_NAME,
                $mode,
                '',
                null,
            ),
            'foo bar baz',
            TypedInput::createForArray(
                new TypeException(
                    <<<'TXT'
                    Expected a null or scalar value. Got the value: "array (
                      0 => 'foo',
                      1 => 'bar',
                      2 => 'baz',
                    )"
                    TXT,
                ),
                ['foo', 'bar', 'baz'],
                new TypeException('Expected an integer string. Got "\'foo\'"'),
                new TypeException('Expected a numeric string. Got "\'foo\'"'),
            ),
        ];

        yield 'null string' => [
            new InputArgument(
                self::ARGUMENT_NAME,
                $mode,
                '',
                null,
            ),
            'null',
            TypedInput::createForArray(
                new TypeException(
                    <<<'TXT'
                    Expected a null or scalar value. Got the value: "array (
                      0 => 'null',
                    )"
                    TXT,
                ),
                ['null'],
                new TypeException('Expected an integer string. Got "\'null\'"'),
                new TypeException('Expected a numeric string. Got "\'null\'"'),
            ),
        ];

        yield 'integer string' => [
            new InputArgument(
                self::ARGUMENT_NAME,
                $mode,
                '',
                null,
            ),
            '10',
            TypedInput::createForArray(
                new TypeException(
                    <<<'TXT'
                    Expected a null or scalar value. Got the value: "array (
                      0 => '10',
                    )"
                    TXT,
                ),
                ['10'],
                [10],
                [10.],
            ),
        ];

        // negative integer string case: skipped see https://github.com/symfony/symfony/issues/27333

        yield 'zero integer string' => [
            new InputArgument(
                self::ARGUMENT_NAME,
                $mode,
                '',
                null,
            ),
            '0',
            TypedInput::createForArray(
                new TypeException(
                    <<<'TXT'
                    Expected a null or scalar value. Got the value: "array (
                      0 => '0',
                    )"
                    TXT,
                ),
                ['0'],
                [0],
                [0.],
            ),
        ];

        yield 'float string' => [
            new InputArgument(
                self::ARGUMENT_NAME,
                $mode,
                '',
                null,
            ),
            '10.8',
            TypedInput::createForArray(
                new TypeException(
                    <<<'TXT'
                    Expected a null or scalar value. Got the value: "array (
                      0 => '10.8',
                    )"
                    TXT,
                ),
                ['10.8'],
                new TypeException('Expected an integer string. Got "\'10.8\'"'),
                [10.8],
            ),
        ];

        // negative float string case: skipped see https://github.com/symfony/symfony/issues/27333

        yield 'zero float string' => [
            new InputArgument(
                self::ARGUMENT_NAME,
                $mode,
                '',
                null,
            ),
            '0.',
            TypedInput::createForArray(
                new TypeException(
                    <<<'TXT'
                    Expected a null or scalar value. Got the value: "array (
                      0 => '0.',
                    )"
                    TXT,
                ),
                ['0.'],
                new TypeException('Expected an integer string. Got "\'0.\'"'),
                [0.],
            ),
        ];
    }

    private function getIO(
        InputArgument $inputArgument,
        string $argument,
    ): IO {
        $application = new Application();
        $application->add(
            new DynamicCommandWithArguments($inputArgument),
        );

        $input = new StringInput('app:input:args '.$argument);
        $input->setInteractive(false);

        $application->doRun(
            $input,
            new NullOutput(),
        );

        $command = $application->find('app:input:args');
        self::assertInstanceOf(DynamicCommandWithArguments::class, $command);

        return new IO(
            $command->input,
            new NullOutput(),
        );
    }
}
