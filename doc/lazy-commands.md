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

    // ...
}
```

Note: Calling the `list` command will instantiate all commands, including lazy commands.


<br />
<hr />

« [How to Call Other Commands](call-other-commands.md) • [Application](application.md) »
