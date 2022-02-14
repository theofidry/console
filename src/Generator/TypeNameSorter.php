<?php

declare(strict_types=1);

namespace Fidry\Console\Generator;

use Fidry\Console\Generator\Type\ComposedType;
use Fidry\Console\Generator\Type\InputType;
use Fidry\Console\Generator\Type\ListType;
use function array_reverse;
use function array_slice;
use function get_class;

final class TypeNameSorter
{
    /**
     * @param list<class-string<InputType>> $typeClassNames
     *
     * @return list<class-string<InputType>>
     */
    public static function sortClassNames(array $typeClassNames): array
    {
        $sortedTypes = [];

        self::traverseAndCollectTypes($typeClassNames, $sortedTypes);

        return $sortedTypes;
    }

    /**
     * @param list<class-string<InputType>> $unsortedTypes
     * @param list<class-string<InputType>> $sortedTypes
     */
    private static function traverseAndCollectTypes(array $unsortedTypes, array &$sortedTypes): void
    {
        foreach ($unsortedTypes as $index => $unsortedType) {
            if (ListType::class !== $unsortedType) {
                $sortedTypes[] = $unsortedType;

                continue;
            }

            $listInnerTypes = array_slice(
                $unsortedTypes,
                $index + 1,
            );

            self::traverseAndCollectTypes($listInnerTypes, $sortedTypes);
            $sortedTypes[] = $unsortedType;

            break;
        }
    }

    private function __construct()
    {
    }
}
