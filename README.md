## Console

Motivation: this library purpose is to provide a lighter and more robust API
for console commands and/or applications to [symfony/console][SymfonyConsole].

It can be used either in combination with [`FrameworkBundle`][FrameworkBundle] to
facilitate the creation of commands or as a stand-alone package to create a CLI
application app.

Key differences:

- Implement interfaces instead of extending classes
- Leverages an `IO` object instead of Input + Output + SymfonyStyle which offers:
    - The API of SymfonyStyle but still access to the Input and Output objects
    - A typed API for arguments and options


## Table of Contents

- [Installation with Symfony](#installation-with-symfony)
- [Usage preview](#usage-preview)
- [Complete documentation](#complete-documentation)
    - [Command](./doc/command.md)
        - [Creating a command](./doc/command.md#creating-a-command)
        - [Configuring the Command](./doc/command.md#configuring-the-command)
        - [Registering the Command](./doc/command.md#registering-the-command)
        - [Executing the Command](./doc/command.md#executing-the-command)
        - [Console Output](./doc/command.md#console-output)
        - [Output Sections](./doc/command.md#output-sections)
        - [Console Input](./doc/command.md#console-input)
        - [Getting Services from the Service Container](./doc/command.md#getting-services-from-the-service-container)
        - [Command Lifecycle](./doc/command.md#command-lifecycle)
        - [Testing Commands](./doc/command.md#testing-commands)
        - [Logging Command Errors](./doc/command.md#logging-command-errors)
        - [Learn More](./doc/command.md#learn-more)
    - [How to Call Other Commands](./doc/call-other-commands.md)
    - [How to Make Commands Lazily Loaded](./doc/lazy-command.md)
    - [Application](./doc/application.md)
        - [Creating an application](./doc/application.md#creating-an-application)
        - [Executing an Application](./doc/application.md#executing-an-application)
- [Known Limitations](#known-limitations)
- [Contributing](#contributing)


### Installation with Symfony

```
$ composer require theofidry/console
```

The Symfony Flex plugin should add the following:

```php
<?php declare(strict_types=1);
// config/bundles.php

return [
    // ...
    // Symfony\Bundle\FrameworkBundle\Symfony\Bundle\FrameworkBundle()
    // ...
    Fidry\Console\FidryConsoleBundle::class => ['all' => true],
];

```

### Usage preview

To implement a command you have to implement the `Fidry\Console\Command\Command` interface as
follows:

```php
<?php declare(strict_types=1);

namespace Acme;

use Acme\MyService;
use Fidry\Console\Command\Command;
use Fidry\Console\Command\Configuration;
use Fidry\Console\ExitCode;
use Fidry\Console\IO;

final class CommandWithService implements Command
{
    private MyService $service;

    public function __construct(MyService $service)
    {
        $this->service = $service;
    }

    public function getConfiguration(): Configuration
    {
        return new Configuration(
            'app:foo',
            'Calls MyService',
            <<<'EOT'
            The <info>%command.name</info> command calls MyService
            EOT,
        );
    }

    public function execute(IO $io): int
    {
        $this->service->call();

        return ExitCode::SUCCESS;
    }
}
```

With the bundle enabled, those services are auto-configured into traditional Symfony commands.


### Known limitations

Some limitations are due to lack of time dedicated to those or based on
the assumption they are not necessary. Those choices may be revisited depending on
of the use case presented.

- Support for hidden commands ([see doc][hidden-commands])
- Support for command aliases
- Support for command usage configuration
- Some methods of `Application`


### Contributing

The project provides a `Makefile` in which the most common commands have been
registered such as fixing the coding style or running the test.

```bash
# Print the list of available commands
make
# or
make help
```


[hidden-commands]: https://symfony.com/doc/current/console/hide_commands.html
[FrameworkBundle]: https://github.com/symfony/framework-bundle
[SymfonyConsole]: https://github.com/symfony/console

