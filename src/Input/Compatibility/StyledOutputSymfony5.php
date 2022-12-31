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

namespace Fidry\Console\Input\Compatibility;

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
interface StyledOutputSymfony5 extends StyleInterface
{
    /**
     * Formats a message as a block of text.
     *
     * @param string|array $messages
     */
    public function block($messages, ?string $type = null, ?string $style = null, string $prefix = ' ', bool $padding = false, bool $escape = true);

    /**
     * Formats a command comment.
     *
     * @param string|array $message
     */
    public function comment($message);

    /**
     * Formats an info message.
     *
     * @param string|array $message
     */
    public function info($message);

    /**
     * Formats a horizontal table.
     */
    public function horizontalTable(array $headers, array $rows);

    /**
     * Formats a list of key/value horizontally.
     *
     * Each row can be one of:
     * * 'A title'
     * * ['key' => 'value']
     * * new TableSeparator()
     *
     * @param string|array|TableSeparator $list
     */
    public function definitionList(...$list);

    /**
     * @see ProgressBar::iterate()
     */
    public function progressIterate(iterable $iterable, ?int $max = null): iterable;

    /**
     * @return mixed
     */
    public function askQuestion(Question $question);

    public function createTable(): Table;

    public function createProgressBar(int $max = 0);
}
