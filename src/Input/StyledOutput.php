<?php

declare(strict_types=1);

namespace Fidry\Console\Input;

use Symfony\Component\Console\Exception\InvalidArgumentException;
use Symfony\Component\Console\Exception\RuntimeException;
use Symfony\Component\Console\Formatter\OutputFormatter;
use Symfony\Component\Console\Helper\Helper;
use Symfony\Component\Console\Helper\ProgressBar;
use Symfony\Component\Console\Helper\SymfonyQuestionHelper;
use Symfony\Component\Console\Helper\Table;
use Symfony\Component\Console\Helper\TableCell;
use Symfony\Component\Console\Helper\TableSeparator;
use Symfony\Component\Console\Output\ConsoleOutputInterface;
use Symfony\Component\Console\Question\Question;
use Symfony\Component\Console\Style\StyleInterface;
use function array_unshift;
use function current;
use function explode;
use function key;
use function max;
use function min;
use function sprintf;
use function str_ends_with;
use function str_repeat;
use function str_replace;
use function substr;
use function substr_count;
use function wordwrap;

interface StyledOutput extends StyleInterface
{
    /**
     * Formats a command comment.
     */
    public function comment(string|array $message);

    /**
     * Formats an info message.
     */
    public function info(string|array $message);

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
     */
    public function definitionList(string|array|TableSeparator ...$list);

    /**
     * @see ProgressBar::iterate()
     */
    public function progressIterate(iterable $iterable, int $max = null): iterable;

    public function askQuestion(Question $question): mixed;

    public function createTable(): Table;
}
