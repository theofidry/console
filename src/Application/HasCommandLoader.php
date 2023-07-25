<?php

declare(strict_types=1);

namespace Fidry\Console\Application;

use Fidry\Console\CommandLoader\CommandLoader;

interface HasCommandLoader
{
    public function getCommandLoader(): CommandLoader;
}