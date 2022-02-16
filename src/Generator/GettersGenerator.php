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

namespace Fidry\Console\Generator;

use function array_map;
use function explode;
use Fidry\Console\Type\InputType;
use function implode;
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
     * @param non-empty-list<InputType>                           $types
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
