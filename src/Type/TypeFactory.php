<?php

declare(strict_types=1);

namespace Fidry\Console\Type;

use Fidry\Console\Type\InputType;
use function array_reverse;

/**
 * @psalm-import-type ArgumentInput from \Fidry\Console\InputAssert
 * @psalm-import-type OptionInput from \Fidry\Console\InputAssert
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
