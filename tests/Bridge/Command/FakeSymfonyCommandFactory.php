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

namespace Fidry\Console\Tests\Bridge\Command;

use DomainException;
use Fidry\Console\Bridge\Command\SymfonyCommandFactory;
use Fidry\Console\Command\Command as FidryCommand;
use Symfony\Component\Console\Command\Command as BaseSymfonyCommand;

final class FakeSymfonyCommandFactory implements SymfonyCommandFactory
{
    public function crateSymfonyCommand(FidryCommand $command): BaseSymfonyCommand
    {
        throw new DomainException('Should not be called.');
    }
}
