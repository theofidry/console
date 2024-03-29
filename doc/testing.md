## Testing

- [Testing an Application](#testing-an-application)
- [Testing a Command](#testing-a-command)


### Testing an Application

Testing an application with this library stays very close to [testing a regular
Symfony application][symfony-app-testing].

This library provides a `Fidry\Console\Test\AppTester` class which is a tiny
layer on top of the traditional `Symfony\Component\Console\Tester\ApplicationTester`.
It differs in two regards:

- It provides an API to create an instance from a ConsoleApplication: `::fromConsoleApp()`
- It can be used combined with `Fidry\Console\Test\OutputAssertions::assertSameOutput()`

See the following example:

```php
<?php declare(strict_types=1);

namespace Fidry\Console\Tests\Test;

use Fidry\Console\{ ExitCode, Test\AppTester, Test\OutputAssertions, Tests\Test\Fixture\Application };
use PHPUnit\Framework\TestCase;
use function str_replace;

final class AppTesterTest extends TestCase
{
    private AppTester $appTester;

    protected function setUp(): void
    {
        $this->appTester = AppTester::fromConsoleApp(
            new Application(),
        );
    }

    public function test_it_can_assert_the_output_via_the_app_tester(): void
    {
        $this->appTester->run(['app:path']);

        OutputAssertions::assertSameOutput(
            <<<'EOS'

            The project path is /home/runner/work/console/console.
            
            EOS,
            '',
            ExitCode::SUCCESS,
            $this->appTester,
        );
    }

    public function test_it_can_assert_the_output_with_custom_normalization_via_the_app_tester(): void
    {
        $this->appTester->run(['app:path']);

        $extraDisplayNormalization = static fn (string $display): string => str_replace(
            '/home/runner/work/console/console',
            '/path/to/console',
            $display,
        );

        OutputAssertions::assertSameOutput(
            <<<'EOS'

            The project path is /path/to/console.

            EOS,
            '',
            ExitCode::SUCCESS,
            $this->appTester,
            $extraDisplayNormalization,
        );
    }
}

```


### Testing a Command

This library provides a `Fidry\Console\Test\CommandTester` class which is a tiny
layer on top of the traditional `Symfony\Component\Console\Tester\CommandTester`.
It differs in two regards:

- It provides an API to create an instance from a ConsoleApplication: `::fromConsoleCommand()`
- It can be used combined with `Fidry\Console\Test\OutputAssertions::assertSameOutput()`

See the following example:

```php
<?php declare(strict_types=1);

namespace Fidry\Console\Tests\Test;

use Fidry\Console\{ ExitCode, Test\CommandTester, Test\OutputAssertions, Tests\Test\Fixture\Application };
use PHPUnit\Framework\TestCase;
use function str_replace;

final class CommandTesterTest extends TestCase
{
    private CommandTester $commandTester;

    protected function setUp(): void
    {
        $this->commandTester = CommandTester::fromConsoleCommand(
            new PathCommand(),
        );
    }

    public function test_it_can_assert_the_output_via_the_app_tester(): void
    {
        $this->commandTester->execute([]);

        OutputAssertions::assertSameOutput(
            <<<'EOT'

            The project path is /home/runner/work/console/console.
            
            EOT,
            '',
            ExitCode::SUCCESS,
            $this->commandTester,
        );
    }
```

More examples can be found on [Symfony doc][symfony-console-testing].


<br />
<hr />

« [Application](application.md) • [Table of Contents](../README.md#table-of-contents) »


[symfony-app-testing]: https://symfony.com/doc/current/console.html#testing-commands
[symfony-console-testing]: https://symfony.com/doc/current/console.html#testing-commands
