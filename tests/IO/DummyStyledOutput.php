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

use Closure;
use Fidry\Console\Output\StyledOutput;
use Fidry\Console\Output\SymfonyStyledOutput;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

final class DummyStyledOutput extends SymfonyStyledOutput
{
    /**
     * @return Closure(InputInterface, OutputInterface):StyledOutput
     */
    public static function getFactory(): Closure
    {
        return static fn (InputInterface $input, OutputInterface $output): StyledOutput => new self($input, $output);
    }
}
