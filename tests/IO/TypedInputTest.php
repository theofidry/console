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

use Fidry\Console\Input\InvalidInputValueType;
use Fidry\Console\Input\TypedInput;
use Fidry\Console\Internal\InputAssert;
use Fidry\Console\IO;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Console\Application;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\StringInput;
use Symfony\Component\Console\Output\NullOutput;

/**
 * Test for the extra methods manually added to the TypedInput object. This could be tested with either InputArgument
 * or InputOption, we are not really testing their specifics there but the method of TypedInput.
 */
#[CoversClass(InputAssert::class)]
#[CoversClass(TypedInput::class)]
final class TypedInputTest extends TestCase
{
    private const ARGUMENT_NAME = 'arg';

    #[DataProvider('choiceListArgumentProvider')]
    public function test_it_get_the_argument_value_as_a_choice_list(
        InputArgument $inputArgument,
        string $argument,
        array $choices,
        ?string $errorMessage,
        string|TypeException $expected
    ): void {
        $argument = $this->getTypedArgument($inputArgument, $argument);

        if ($expected instanceof TypeException) {
            $this->expectException(InvalidInputValueType::class);
            $this->expectExceptionMessage($expected->message);
        }

        $actual = $argument->asStringChoice(
            $choices,
            $errorMessage,
        );

        self::assertSame($expected, $actual);
    }

    public static function choiceListArgumentProvider(): iterable
    {
        yield 'valid value' => [
            new InputArgument(
                self::ARGUMENT_NAME,
                InputArgument::REQUIRED,
                '',
                null,
            ),
            'choiceB',
            ['choiceA', 'choiceB', 'choiceC'],
            null,
            'choiceB',
        ];

        yield 'invalid value' => [
            new InputArgument(
                self::ARGUMENT_NAME,
                InputArgument::REQUIRED,
                '',
                null,
            ),
            'choiceZ',
            ['choiceA', 'choiceB', 'choiceC'],
            null,
            new TypeException('Expected one of: "choiceA", "choiceB", "choiceC". Got: "choiceZ" for the argument "'.self::ARGUMENT_NAME.'".'),
        ];

        yield 'invalid value with custom error message' => [
            new InputArgument(
                self::ARGUMENT_NAME,
                InputArgument::REQUIRED,
                '',
                null,
            ),
            'choiceZ',
            ['choiceA', 'choiceB', 'choiceC'],
            'This is my custom error message. Previous message: %s',
            new TypeException('This is my custom error message. Previous message: Expected one of: "choiceA", "choiceB", "choiceC". Got: "choiceZ" for the argument "'.self::ARGUMENT_NAME.'".'),
        ];
    }

    /**
     * @param positive-int|0 $min
     * @param positive-int|0 $max
     */
    #[DataProvider('naturalWithinRangeArgumentProvider')]
    public function test_it_get_the_argument_value_as_a_natural_within_range(
        InputArgument $inputArgument,
        string $argument,
        int $min,
        int $max,
        ?string $errorMessage,
        int|TypeException $expected
    ): void {
        $argument = $this->getTypedArgument($inputArgument, $argument);

        if ($expected instanceof TypeException) {
            $this->expectException(InvalidInputValueType::class);
            $this->expectExceptionMessage($expected->message);
        }

        $actual = $argument->asNaturalWithinRange(
            $min,
            $max,
            $errorMessage,
        );

        self::assertSame($expected, $actual);
    }

    public static function naturalWithinRangeArgumentProvider(): iterable
    {
        yield 'valid value' => [
            new InputArgument(
                self::ARGUMENT_NAME,
                InputArgument::REQUIRED,
                '',
                null,
            ),
            '10',
            1,
            20,
            null,
            10,
        ];

        yield 'invalid value' => [
            new InputArgument(
                self::ARGUMENT_NAME,
                InputArgument::REQUIRED,
                '',
                null,
            ),
            '10',
            1,
            3,
            null,
            new TypeException('Expected a value between 1 and 3. Got: 10 for the argument "'.self::ARGUMENT_NAME.'".'),
        ];

        yield 'invalid value with custom error message' => [
            new InputArgument(
                self::ARGUMENT_NAME,
                InputArgument::REQUIRED,
                '',
                null,
            ),
            '10',
            1,
            3,
            'This is my custom error message. Previous message: %s',
            new TypeException('This is my custom error message. Previous message: Expected a value between 1 and 3. Got: 10 for the argument "'.self::ARGUMENT_NAME.'".'),
        ];
    }

    private function getTypedArgument(
        InputArgument $inputArgument,
        string $argument
    ): TypedInput {
        return $this->getIO($inputArgument, $argument)->getTypedArgument(self::ARGUMENT_NAME);
    }

    private function getIO(
        InputArgument $inputArgument,
        string $argument
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
