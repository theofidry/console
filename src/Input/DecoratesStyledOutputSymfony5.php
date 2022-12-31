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

/*
 * This file is part of the box project.
 *
 * (c) Kevin Herrera <kevin@herrera.io>
 *     Théo Fidry <theo.fidry@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Fidry\Console\Input;

use Symfony\Component\Console\Formatter\OutputFormatterInterface;
use Symfony\Component\Console\Helper\Table;
use Symfony\Component\Console\Input\InputDefinition;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\Question;
use Symfony\Component\Console\Style\SymfonyStyle;
use function func_get_args;

/**
 * @internal
 * @psalm-require-implements StyledOutput
 */
trait DecoratesStyledOutputSymfony5
{
    private StyledOutput $styledOutput;

    public function block($messages, string $type = null, string $style = null, string $prefix = ' ', bool $padding = false, bool $escape = true) {
        return $this->styledOutput->block(...func_get_args());
    }

    public function title(string $message) {
        return $this->styledOutput->title(...func_get_args());
    }

    public function section(string $message) {
        return $this->styledOutput->section(...func_get_args());
    }

    public function listing(array $elements) {
        return $this->styledOutput->listing(...func_get_args());
    }

    public function text($message) {
        return $this->styledOutput->text(...func_get_args());
    }

    public function comment($message) {
        return $this->styledOutput->comment(...func_get_args());
    }

    public function success($message) {
        return $this->styledOutput->success(...func_get_args());
    }

    public function error($message) {
        return $this->styledOutput->error(...func_get_args());
    }

    public function warning($message) {
        return $this->styledOutput->warning(...func_get_args());
    }

    public function note($message) {
        return $this->styledOutput->note(...func_get_args());
    }

    public function info($message) {
        return $this->styledOutput->info(...func_get_args());
    }

    public function caution($message) {
        return $this->styledOutput->caution(...func_get_args());
    }

    public function table(array $headers, array $rows) {
        return $this->styledOutput->table(...func_get_args());
    }

    public function horizontalTable(array $headers, array $rows) {
        return $this->styledOutput->horizontalTable(...func_get_args());
    }

    public function definitionList(...$list) {
        return $this->styledOutput->definitionList(...func_get_args());
    }

    public function ask(string $question, string $default = null, callable $validator = null) {
        return $this->styledOutput->ask(...func_get_args());
    }

    public function askHidden(string $question, callable $validator = null) {
        return $this->styledOutput->askHidden(...func_get_args());
    }

    public function confirm(string $question, bool $default = true) {
        return $this->styledOutput->confirm(...func_get_args());
    }

    public function choice(string $question, array $choices, $default = null) {
        return $this->styledOutput->choice(...func_get_args());
    }

    public function progressStart(int $max = 0) {
        return $this->styledOutput->progressStart(...func_get_args());
    }

    public function progressAdvance(int $step = 1) {
        return $this->styledOutput->progressAdvance(...func_get_args());
    }

    public function progressFinish() {
        return $this->styledOutput->progressFinish(...func_get_args());
    }

    public function createProgressBar(int $max = 0) {
        return $this->styledOutput->createProgressBar(...func_get_args());
    }

    public function progressIterate(iterable $iterable, int $max = null): iterable {
        return $this->styledOutput->progressIterate(...func_get_args());
    }

    public function askQuestion(Question $question) {
        return $this->styledOutput->askQuestion(...func_get_args());
    }

    public function newLine(int $count = 1) {
        return $this->styledOutput->newLine(...func_get_args());
    }

    public function getErrorStyle() {
        return $this->styledOutput->getErrorStyle(...func_get_args());
    }

    public function createTable(): Table {
        return $this->styledOutput->createTable(...func_get_args());
    }
}
