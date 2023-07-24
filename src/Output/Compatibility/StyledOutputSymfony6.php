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

namespace Fidry\Console\Output\Compatibility;

use Symfony\Component\Console\Helper\ProgressBar;
use Symfony\Component\Console\Helper\Table;
use Symfony\Component\Console\Helper\TableSeparator;
use Symfony\Component\Console\Question\Question;
use Symfony\Component\Console\Style\StyleInterface;

/**
 * Complements the Symfony Style interface with the methods present in
 * SymfonyStyle that are not in the interface due to BC breaks concerns.
 *
 * @internal
 */
interface StyledOutputSymfony6 extends StyleInterface
{
    /**
     * Formats a message as a block of text.
     */
    public function block(string|array $messages, ?string $type = null, ?string $style = null, string $prefix = ' ', bool $padding = false, bool $escape = true): void;

    /**
     * Formats a command comment.
     */
    public function comment(string|array $message): void;

    /**
     * Formats an info message.
     */
    public function info(string|array $message): void;

    /**
     * Formats a horizontal table.
     */
    public function horizontalTable(array $headers, array $rows): void;

    /**
     * Formats a list of key/value horizontally.
     *
     * Each row can be one of:
     * * 'A title'
     * * ['key' => 'value']
     * * new TableSeparator()
     */
    public function definitionList(string|array|TableSeparator ...$list): void;

    /**
     * @see ProgressBar::iterate()
     */
    public function progressIterate(iterable $iterable, ?int $max = null): iterable;

    public function askQuestion(Question $question): mixed;

    public function createTable(): Table;

    public function createProgressBar(int $max = 0): ProgressBar;
}
