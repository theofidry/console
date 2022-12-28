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

namespace Fidry\Console\Tests\AutoReview;

use Fidry\Makefile\Test\BaseMakefileTestCase;

/**
 * @internal
 */
final class MakefileTest extends BaseMakefileTestCase
{
    protected static function getMakefilePath(): string
    {
        return __DIR__.'/../../Makefile';
    }

    protected function getExpectedHelpOutput(): string
    {
        return <<<'EOF'
            [33mUsage:[0m
              make TARGET

            [32m#
            # Commands
            #---------------------------------------------------------------------------[0m
            [33mhelp:[0m  Shows the help
            [33mdefault:[0m  Runs the default task
            [33mdump:[0m	 Dumps the getter
            [33mcs:[0m  Runs PHP-CS-Fixer
            [33mautoreview:[0m  Runs the AutoReview checks
            [33mcs_lint:[0m  Runs the CS linters
            [33mpsalm:[0m  Runs Psalm
            [33minfection:[0m  Runs infection
            [33mtest:[0m  Runs all the tests
            [33mvalidate-package:[0m  Validates the Composer package
            [33mphpunit:[0m  Runs PHPUnit
            [33mcoverage:[0m  Runs PHPUnit with code coverage
            [33mclear-cache:[0m  Clears the integration test app cache

            EOF;
    }
}
