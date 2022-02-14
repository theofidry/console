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

final class IOGettersGenerator
{
    private const TEMPLATE_PATH = __DIR__.'/../IOGetters.tpl.php';
    private const TARGET_PATH = __DIR__.'/../IOGetters.php';

    public static function generate(): void
    {
        $template = file_get_contents(self::TEMPLATE_PATH);

        $map = new TypeMap();

        $getters = [];

        foreach (ParameterType::ALL as $parameterType) {
            foreach ($map->provideMap() as $type) {
                $getters[] = self::indentGetter(
                    GetterGenerator::generate(
                        $parameterType,
                        $type,
                    ),
                );
                $getters[] = '';
            }
        }

        $content = str_replace(
            '// __GETTERS_PLACEHOLDER__',
            "\n".implode(
                "\n",
                $getters,
            ),
            $template,
        );

        file_put_contents(self::TARGET_PATH, $content);
    }

    private static function indentGetter(string $getter): string
    {
        $getterLines = explode("\n", $getter);

        $indentedGetterLines = array_map(
            static fn (string $getter) => '    '.$getter,
            $getterLines,
        );

        return implode("\n", $indentedGetterLines);
    }
}
