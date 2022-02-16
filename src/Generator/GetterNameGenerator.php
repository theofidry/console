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
use function array_unshift;
use Fidry\Console\Internal\Type\InputType;
use function implode;
use function Safe\substr;
use function ucfirst;

/**
 * @private
 */
final class GetterNameGenerator
{
    private function __construct()
    {
    }

    /**
     * @param ParameterType::ARGUMENT|ParameterType::OPTION $parameterType
     * @param list<class-string<InputType>>                 $typeClassNames
     */
    public static function generateMethodName(string $parameterType, array $typeClassNames): string
    {
        $typeParts = array_map(
            static fn (string $typeClassName) => self::normalizeTypeName($typeClassName),
            TypeNameSorter::sortClassNames($typeClassNames),
        );

        $nameParts = array_map(
            static fn (string $part) => ucfirst(mb_strtolower($part)),
            [
                ...$typeParts,
                $parameterType,
            ],
        );

        array_unshift($nameParts, 'get');

        return implode('', $nameParts);
    }

    /**
     * @param class-string<InputType> $typeClassName
     */
    private static function normalizeTypeName(string $typeClassName): string
    {
        return substr(
            ClassName::getShortClassName($typeClassName),
            0,
            -4,
        );
    }
}
