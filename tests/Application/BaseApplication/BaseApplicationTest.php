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
use Fidry\Console\Bridge\Application\SymfonyApplication;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Console\Application as SymfonyNativeApplication;

#[CoversClass(BaseApplication::class)]
final class BaseApplicationTest extends TestCase
{
    public function test_it_shares_defaults_with_the_symfony_application(): void
    {
        $application = new MinimalApplication();
        $bridgedSymfonyApp = new SymfonyApplication($application);

        $symfonyApp = new SymfonyNativeApplication(
            $application->getName(),
            $application->getVersion(),
        );

        self::assertApplicationsHaveSameState($symfonyApp, $bridgedSymfonyApp);
    }

    private static function assertApplicationsHaveSameState(
        SymfonyNativeApplication $expected,
        SymfonyNativeApplication $actual,
    ): void {
        self::assertEquals(
            self::getApplicationState($expected),
            self::getApplicationState($actual),
        );
    }

    /** @psalm-suppress InternalMethod */
    private static function getApplicationState(SymfonyNativeApplication $application): array
    {
        return [
            'name' => $application->getName(),
            'version' => $application->getVersion(),
            'longVersion' => $application->getLongVersion(),
            'catchExceptions' => $application->areExceptionsCaught(),
            'autoExit' => $application->isAutoExitEnabled(),
            'singleCommand' => $application->isSingleCommand(),
        ];
    }
}
