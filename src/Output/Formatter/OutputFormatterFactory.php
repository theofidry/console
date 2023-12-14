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

use Symfony\Component\Console\Formatter\OutputFormatterInterface;

interface OutputFormatterFactory
{
    public function create(): OutputFormatterInterface;
}
