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
            [33mhelp:[0m 	 Shows the help
            [33mdump:[0m	 Dumps the getter
            [33mcheck:[0m   Runs all the checks
            [33mautoreview:[0m  Runs the AutoReview checks
            [33mtest:[0m 	     Runs the tests
            [33mcs:[0m 	     Runs the CS fixers
            [33mcs_lint:[0m     Runs the CS linters
            [33mphpunit_coverage_infection:[0m  Runs PHPUnit tests with test coverage
            [33mphpunit_coverage_html:[0m	     Runs PHPUnit with code coverage with HTML report
            [33mclean:[0m   Cleans up all artefacts
            [33minstall_symfony4:[0m  Installs latest dependencies with Symfony4
            [33minstall_symfony5:[0m  Installs latest dependencies with Symfony5
            [33minstall_symfony6:[0m  Installs latest dependencies with Symfony6

            EOF;
    }
}
