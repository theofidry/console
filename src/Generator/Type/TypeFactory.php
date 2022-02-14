<?php

declare(strict_types=1);

namespace Fidry\Console\Generator\Type;

use function array_reverse;

/**
 * @psalm-import-type ArgumentInput from \Fidry\Console\Command\ConsoleAssert
 * @psalm-import-type OptionInput from \Fidry\Console\Command\ConsoleAssert
 * @template ValueType
 */
final class TypeFactory
{
    /**
     * @param non-empty-list<class-string<InputType>> $typeClassNames
     */
    public static function createTypeFromClassNames(array $typeClassNames): InputType
    {
        $type = null;
        $args = [];

        foreach (array_reverse($typeClassNames) as $typeClassName) {
            $type = new $typeClassName(...$args);
            $args = [$type];
        }

        return $type;
    }

    private function __construct()
    {
    }
}
