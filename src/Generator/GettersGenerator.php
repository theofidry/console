<?php

declare(strict_types=1);

namespace Fidry\Console\Generator;

use Fidry\Console\Type\InputType;
use function array_map;
use function array_pop;
use function array_shift;
use function array_unshift;
use function explode;
use function rtrim;
use function Safe\file_put_contents;
use function Safe\file_get_contents;
use function implode;
use function Safe\sprintf;
use function str_repeat;
use function str_replace;

final class GettersGenerator
{
    private const TEMPLATE = <<<'PHP'
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

    namespace Fidry\Console;

    use Fidry\Console\Type\TypeFactory;

    trait IOGetters
    {
        // __GETTERS_PLACEHOLDER__
    }
    PHP;

    /**
     * @param non-empty-list<InputType> $types
     * @param list<ParameterType::ARGUMENT|ParameterType::OPTION> $parameterTypes
     */
    public static function generate(array $types, array $parameterTypes): string
    {
        $getters = [];

        foreach ($parameterTypes as $parameterType) {
            foreach ($types as $type) {
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
            self::TEMPLATE,
        );

        return self::trimTrailingSpaces($content);
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

    private static function trimTrailingSpaces(string $content): string
    {
        $lines = explode("\n", $content);

        $trimmedLines = array_map('rtrim', $lines);

        return implode("\n", $trimmedLines);
    }
}
