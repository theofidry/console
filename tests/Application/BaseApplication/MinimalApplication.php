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

namespace Fidry\Console\Tests\Application\BaseApplication;

use Fidry\Console\Application\BaseApplication;

final class MinimalApplication extends BaseApplication
{
    public function getName(): string
    {
        return 'MinimalApp';
    }

    public function getVersion(): string
    {
        return 'v1.0.0-dev';
    }

    public function getCommands(): array
    {
        return [];
    }
}
