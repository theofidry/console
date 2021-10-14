## How to Make Commands Lazily Loaded

To make your command lazily loaded, you need to implement the
`Fidry\Console\Command\LazyCommand` interface:

```php
<?php declare(strict_types=1);

// src/Console/Command/CreateUserCommand.php
namespace App\Console\Command;

use Fidry\Console\Command\LazyCommand;

final class CreateUserCommand implements LazyCommand
{
    // ...

    public static function getName(): string
    {
        return 'app:create-user';
    }

    public static function getDescription(): string
    {
        return 'Adds a user';
    }

    // ...
}
```

Due to the design of `Fidry\Console\Command\LazyCommand`, you can have one and
only one lazy command instance per class. If you wish to circumvent this, you
can still implement a lazy command the "regular" way:

- Implement `Fidry\Console\Command\Command` instead of `Fidry\Console\Command\LazyCommand`
- Adjust the service registration as follows:

```yaml
services:
    // ...
    
    # You need to register the command you wish to make lazy as a regular 
    # service.
    # This means auto-configure must be disabled for it otherwise its service
    # definition would be replaced into a traditional (non-lazy) command
    App\Console\Command\CreateUserCommand:
        autoconfigure: false

    # Here you basically do what is automatically done by Fidry\Console\DependencyInjection\Compiler\AddConsoleCommandPass
    # i.e. registering the package command as a regular Symfony command.
    app.simple_lazy_1:
        class: Fidry\Console\Command\SymfonyCommand
        arguments:
            - '@App\Console\Command\CreateUserCommand'
        tags:
            - name: 'console.command'
              command: 'app:simple-lazy-1'
              description: 'First instance of a "traditional" lazy Symfony command'

    app.simple_lazy_2:
        class: Fidry\Console\Command\SymfonyCommand
        arguments:
            - '@App\Console\Command\CreateUserCommand'
        tags:
            - name: 'console.command'
              command: 'app:simple-lazy-2'
              description: 'Second instance of a "traditional" lazy Symfony command'
```

Note that with the example above, you will have a service `App\Console\Command\CreateUserCommand`
that is shared for the two lazy commands. If you do not want this then you should
register two dedicated services instead, e.g. `app.create_user_1` and `app.create_user_2`.


<br />
<hr />

« [How to Call Other Commands](call-other-commands.md) • [Application](application.md) »
