<?php

declare(strict_types=1);

use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\ControllerMetadata\ArgumentMetadata;

class MyApp extends \Symfony\Component\Console\Application {
    public function __construct(string $name = 'UNKNOWN', string $version = 'UNKNOWN')
    {
        parent::__construct($name, $version);

        $this->setCommandLoader(
            new \Symfony\Component\Console\CommandLoader\FactoryCommandLoader([
                'app:hello' => fn () => new HelloCommand(),
            ]),
        );
    }
}

final class HelloCommand extends Command
{

}

#[AsCommand(
    name: 'app:hello'
)]
final class HelloCommand extends Command {

}


# Without value resolver
#[AsCommand(
    name: 'app:hello',
    description: '...',
)]
final class HelloCommand {
    public function __invoke(
        OutputInterface $output,

        UserRepository $userRepository,

        #[Autowire(service: 'mailer')]
        MailerInterface $mailer,

        #[InputArgument(mode: InputArgument::REQUIRED)]
        string $email,

        #[InputOption(mode: InputOption::VALUE_IS_ARRAY)]
        array $roles,
    ): int {
        $user = new User($email, $role);
        $userRepository->save($user);

        $mailer->send(...);
    }
}

#[AsCommand(
    name: 'app:hello',
    description: '...',
)]
final class HelloCommand implements CommandInterface {
    function getConfiguration() {
        return new Configuration(
            'app:hello',
            '...',
            hidden: true,
        );
    }

    public function __invoke(
        OutputInterface $output,

        UserRepository $userRepository,

        #[Autowire(service: 'mailer')]
        MailerInterface $mailer,

        #[InputArgument(mode: InputArgument::REQUIRED)]
        string $email,

        #[InputOption(mode: InputOption::VALUE_IS_ARRAY)]
        array $roles,
    ): int {
        $user = new User($email, $role);
        $userRepository->save($user);

        $mailer->send(...);
    }
}

// input definition = f(HelloCommand::__invoke())



# With value resolver
#[AsCommand(
    name: 'app:hello'
)]
final class HelloCommand {



    public function __invoke(
        OutputInterface $output,

        UserRepository $userRepository,

        #[Autowire(service: 'mailer')]
        MailerInterface $mailer,

        #[ParamConverter(
            UserConverter::class,
            arguments: [
                new InputArgument(
                    'email',
                    InputArgument::REQUIRED,
                ),
            ],
            options: [
                new InputOption(
                    'role',
                    InputOption::VALUE_IS_ARRAY,
                ),
            ],
        )]
        User $user,
    ): int {
        $user = new User($email, $role);
        $userRepository->save($user);

        $mailer->send(...);
    }
}

class UserConverter {
    public function resolve(InputInterface $input, ArgumentMetadata $argument): iterable
    {

    }
}

// input definition = f(HelloCommand::__invoke())

