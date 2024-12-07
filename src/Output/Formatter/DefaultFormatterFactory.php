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

namespace Fidry\Console\Output\Formatter;

use Closure;
use Symfony\Component\Console\Formatter\OutputFormatterInterface;

final class DefaultFormatterFactory implements OutputFormatterFactory
{
    /**
     * @param Closure(): OutputFormatterFactory $factory
     */
    public function __construct(private Closure $factory)
    {
    }

    public function create(): OutputFormatterInterface
    {
        return ($this->factory)();
    }
}
