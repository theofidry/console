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

namespace Fidry\Console\Test;

use PHPUnit\Framework\Test;
use Symfony\Component\Console\Tester\ApplicationTester;

interface AppTesterTestCase extends Test
{
    public function getAppTester(): ApplicationTester;
}
