## How to Make Commands Lazily Loaded

There is two ways to make a command lazily loaded.

The first way is, if your command is a standard command, to
make it lazy by registering it like as follows to your application:

```php
<?php declare(strict_types=1);

// src/Console/Application.php
namespace App\Console;

use App\Console\Command\CreateUserCommand;
use Fidry\Console\Application\Application as FidryApplication;
use Fidry\Console\Command\LazyCommandEnvelope;
use function sprintf;

final class Application implements FidryApplication
{
    // ...

    public function getCommands() : array
    {
        return [
            // Declare a lazy command
            new LazyCommandEnvelope(
                'app:wrapped-lazy',
                'Wrapped lazy command description.',
                static fn () => new CreateUserCommand(/*...*/),
            ),
            // Alternatively, you can wrap it directly if
            // it implements the FidryLazyCommand interface.
            LazyCommandEnvelope::wrap(
                CreateUserCommand::class,
                static fn () => new CreateUserCommand(/*...*/),
            ),
        ];
    }
}
```

The other way is to implement the `Fidry\Console\Command\LazyCommand` interface:

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
only one lazy command instance per class. If you wish to get around this limitation, you
can still implement a lazy command the "regular" way:

- Implement `Fidry\Console\Command\Command` instead of `Fidry\Console\Command\LazyCommand`
- Make use of the `Fidry\Console\Command\LazyCommandEnvelope` (see at the beginning of this page).
- Alternatively, you can also adjust the service registration as follows if you are in a Symfony application:

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
