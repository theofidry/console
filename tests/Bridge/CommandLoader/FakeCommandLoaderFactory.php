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

namespace Fidry\Console\Tests\Bridge\CommandLoader;

use DomainException;
use Fidry\Console\Bridge\CommandLoader\CommandLoaderFactory;
use Symfony\Component\Console\CommandLoader\CommandLoaderInterface;

final class FakeCommandLoaderFactory implements CommandLoaderFactory
{
    public function createCommandLoader(array $commands): CommandLoaderInterface
    {
        throw new DomainException('Should not be called.');
    }
}
