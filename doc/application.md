## Application

- [Creating an application](#creating-an-application)
- [Executing an Application](#executing-an-application)

This library ships with an Application API for standalone apps (i.e. when not
using [`FrameworkBundle`][FrameworkBundle] – otherwise you very unlikely need it).


### Creating an application

Applications are declared as classes implementing `Fidry\Console\Application\Application`. For
example:

```php
<?php declare(strict_types=1);

// src/Console/Application.php
namespace App\Console;

use App\Console\Command\CreateUserCommand;
use Fidry\Console\Application\Application as FidryApplication;
use function sprintf;

final class Application implements FidryApplication
{
    public function getName() : string
    {
         return 'MyApp';
    }
    
    public function getVersion() : string
    {
        return '1.0.0';
    }
    
    public function getLongVersion() : string
    {
        return sprintf(
            '%s %s',
            $this->getName(),
            $this->getVersion(),
        );
    }
    
    public function getHelp() : string
    {
        return $this->getLongVersion();
    }

    public function getCommands() : array
    {
        return [
            new CreateUserCommand(),
        ];
    }

    public function getDefaultCommand() : string
    {
        return 'list';    
    }

    public function isAutoExitEnabled() : bool
    {
        return true;
    }

    public function areExceptionsCaught() : bool
    {
        return true;
    }
}
```

If you wish to have most of the configuration as close as possible to the default
Symfony application `Symfony\Component\Console\Application`, you can instead
extend the class `Fidry\Console\Application\BaseApplication`.


### Executing an Application

A traditional Symfony application CLI script looks as follow:

```php
#!/usr/bin/env php
<?php declare(strict_types=1);
// bin/my-app.php

use Symfony\Component\Console\Application;

if (!in_array(PHP_SAPI, ['cli', 'phpdbg', 'embed'], true)) {
    echo 'Warning: The console should be invoked via the CLI version of PHP, not the '.PHP_SAPI.' SAPI'.PHP_EOL;
}

set_time_limit(0);

require dirname(__DIR__).'/vendor/autoload.php';

(new Application())->run();

```

A lot more can be done here for example configuring environment variables, adapting the input
executed and using a custom application. For example see the Symfony Demo [console][demo-console].

With this library, you instead rely on an Application runner: 

```php
#!/usr/bin/env php
<?php declare(strict_types=1);
// bin/my-app.php

use App\Console\MyApplication;
use Fidry\Console\Application\ApplicationRunner;

if (!in_array(PHP_SAPI, ['cli', 'phpdbg', 'embed'], true)) {
    echo 'Warning: The console should be invoked via the CLI version of PHP, not the '.PHP_SAPI.' SAPI'.PHP_EOL;
}

set_time_limit(0);

require dirname(__DIR__).'/vendor/autoload.php';

ApplicationRunner::runApplication(new MyApplication());

```

This application runner is a thin layer that allows to port back this library
API to a regular Symfony application execution.


<br />
<hr />

« [How to Make Commands Lazily Loaded](lazy-command.md) • [Testing](testing.md) »


[demo-console]: https://github.com/symfony/demo/blob/main/bin/console
[FrameworkBundle]: https://github.com/symfony/framework-bundle
