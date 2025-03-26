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

namespace Fidry\Console\Test;

use PHPUnit\Framework\Assert;
use Symfony\Component\Console\Tester\Constraint\CommandIsSuccessful;
use function array_filter;
use function call_user_func;
use function function_exists;
use function implode;
use function str_replace;
use const PHP_EOL;

final class ExecutionResult
{
    public static function fromTestOutput(
        string $intput,
        int $statusCode,
        TestOutput $testOutput,
    ) {
        return new self(
            $statusCode,
            $testOutput->getOutputContents(),
            $testOutput->getErrorOutputContents(),
            $testOutput->getDisplayContents(),
        );
    }

    public function __construct(
        private string $input,
        private int $statusCode,
        private string $output,
        private string $errorOutput,
        private string $display,
    ) {
    }

    /**
     * Gets the status code returned by the execution of the command or application.
     */
    public function getStatusCode(): int
    {
        return $this->statusCode;
    }

    /**
     * Gets the display returned by the execution of the command or application. The display combines what was
     * written on both the output and error output.
     *
     * @param bool $normalize Whether to normalize end of lines to \n or not.
     */
    public function getDisplay(bool $normalize = false): string
    {
        return $normalize
            ? self::normalizeEndOfLines($this->display)
            : $this->display;
    }

    /**
     * Gets the output written to the output by the command or application.
     *
     * @param bool $normalize Whether to normalize end of lines to \n or not.
     */
    public function getOutput(bool $normalize = false): string
    {
        return $normalize
            ? self::normalizeEndOfLines($this->output)
            : $this->output;
    }

    /**
     * Gets the output written to the error output by the command or application.
     *
     * @param bool $normalize Whether to normalize end of lines to \n or not.
     */
    public function getErrorOutput(bool $normalize = false): string
    {
        return $normalize
            ? self::normalizeEndOfLines($this->errorOutput)
            : $this->errorOutput;
    }

    public function assertCommandIsSuccessful(string $message = ''): void
    {
        Assert::assertThat($this->statusCode, new CommandIsSuccessful(), $message);
    }

    public function assertOutputContains(string $expected): self
    {
        Assert::that($this->output())->contains($expected);

        return $this;
    }

    public function assertOutputNotContains(string $expected): self
    {
        Assert::that($this->output())->doesNotContain($expected);

        return $this;
    }

    public function assertErrorOutputContains(string $expected): self
    {
        Assert::that($this->errorOutput())->contains($expected);

        return $this;
    }

    public function assertErrorOutputNotContains(string $expected): self
    {
        Assert::that($this->errorOutput())->doesNotContain($expected);

        return $this;
    }

    public function assertSuccessful(): self
    {
        return $this->assertStatusCode(0);
    }

    public function assertStatusCode(int $expected): self
    {
        Assert::that($this->statusCode())->is($expected);

        return $this;
    }

    public function dump(): self
    {
        $summary = "CLI: {$this->cli}, Status: {$this->statusCode()}";
        $output = [
            $summary,
            $this->output(),
            $this->errorOutput(),
            $summary,
        ];

        call_user_func(
            function_exists('dump') ? 'dump' : 'var_dump',
            implode("\n\n", array_filter($output)),
        );

        return $this;
    }

    public function dd(): void
    {
        $this->dump();
        exit(1);
    }

    private static function normalizeEndOfLines(string $value): string
    {
        return str_replace(PHP_EOL, "\n", $value);
    }
}
