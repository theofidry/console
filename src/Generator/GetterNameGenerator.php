<?php

declare(strict_types=1);

namespace Fidry\Console\Generator;

use Fidry\Console\Command\ConsoleAssert;
use Fidry\Console\Generator\Type\InputType;
use Fidry\Console\Generator\Type\ListType;
use function array_map;
use function array_shift;
use function array_unshift;
use function implode;
use function Safe\substr;
use function strtolower;
use function ucfirst;

final class GetterNameGenerator
{
    /**
     * @param ParameterType::ARGUMENT|ParameterType::OPTION $parameterType $parameterType
     * @param list<class-string<InputType>> $typeClassNames
     */
    public static function generateMethodName(string $parameterType, array $typeClassNames): string
    {
        $typeParts = array_map(
            static fn (string $typeClassName) => self::normalizeTypeName($typeClassName),
            TypeNameSorter::sortClassNames($typeClassNames),
        );

        $nameParts = array_map(
            static fn (string $part) => ucfirst(strtolower($part)),
            [
                ...$typeParts,
                $parameterType,
            ],
        );

        array_unshift($nameParts, 'get');

        return implode('', $nameParts);
    }

    private static function normalizeTypeName(string $typeClassName): string
    {
        return substr(
            ClassName::getShortClassName($typeClassName),
            0,
            -4,
        );
    }

    private function __construct()
    {
    }
}
