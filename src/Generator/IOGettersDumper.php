<?php

declare(strict_types=1);

namespace Fidry\Console\Generator;

use Fidry\Console\Command\ConsoleAssert;
use Fidry\Console\Generator\Type\InputType;
use function array_map;
use function array_pop;
use function array_shift;
use function array_unshift;
use function explode;
use function Safe\file_put_contents;
use function Safe\file_get_contents;
use function implode;
use function Safe\sprintf;
use function str_repeat;
use function str_replace;

final class IOGettersDumper
{
    private const TARGET_PATH = __DIR__.'/../IOGetters.php';

    public static function generate(): void
    {
        $content = GettersGenerator::generate(
            TypeMap::provideTypes(),
            ParameterType::ALL,
        );

        file_put_contents(self::TARGET_PATH, $content);
    }
}
