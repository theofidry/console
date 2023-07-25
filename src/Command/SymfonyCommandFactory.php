<?php

namespace Fidry\Console\Command;

use Fidry\Console\Command\Command as FidryCommand;
use Symfony\Component\Console\Command\Command as BaseSymfonyCommand;

interface SymfonyCommandFactory
{
    public function crateSymfonyCommand(FidryCommand $command): BaseSymfonyCommand;
}