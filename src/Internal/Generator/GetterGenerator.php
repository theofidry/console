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

namespace Fidry\Console\Internal\Generator;

use function array_map;
use function array_shift;
use function array_unshift;
use Fidry\Console\Internal\Type\InputType;
use function implode;
use function Safe\sprintf;
use function str_repeat;
use function str_replace;

/**
 * @private
 */
final class GetterGenerator
{
    private const TEMPLATE = <<<'PHP'
    /**
     * @return __PSALM_RETURN_TYPE_PLACEHOLDER__
     */
    public function __METHOD_NAME_PLACEHOLDER__()__PHP_RETURN_TYPE_PLACEHOLDER__
    {
        $type = TypeFactory::createTypeFromClassNames([
        __TYPE_CLASS_NAMES_PLACEHOLDER__
        ]);
    
        return $type->coerceValue($this->value);
    }
    PHP;

    private const INDENT_SIZE = 4;

    private function __construct()
    {
    }

    public static function generate(InputType $type): string
    {
        $typeClassNames = $type->getTypeClassNames();

        $phpReturnType = $type->getPhpTypeDeclaration();

        if (null !== $phpReturnType) {
            $phpReturnType = ': '.$phpReturnType;
        }

        return str_replace(
            [
                '__METHOD_NAME_PLACEHOLDER__',
                '__PSALM_RETURN_TYPE_PLACEHOLDER__',
                '__PHP_RETURN_TYPE_PLACEHOLDER__',
                '__TYPE_CLASS_NAMES_PLACEHOLDER__',
            ],
            [
                GetterNameGenerator::generateMethodName($typeClassNames),
                $type->getPsalmTypeDeclaration(),
                (string) $phpReturnType,
                self::serializeTypeNames($typeClassNames),
            ],
            self::TEMPLATE,
        );
    }

    /**
     * @param non-empty-list<class-string<InputType>> $typeClassNames
     */
    private static function serializeTypeNames(array $typeClassNames): string
    {
        $firstTypeClassName = array_shift($typeClassNames);

        $formattedTypeClassNames = array_map(
            static fn (string $typeClassName) => self::formatTypeClassName($typeClassName, 2),
            $typeClassNames,
        );

        array_unshift(
            $formattedTypeClassNames,
            self::formatTypeClassName($firstTypeClassName, 1),
        );

        return implode("\n", $formattedTypeClassNames);
    }

    /**
     * @param class-string<InputType> $typeClassName
     * @param positive-int            $indentSize
     */
    private static function formatTypeClassName(string $typeClassName, int $indentSize): string
    {
        return sprintf(
            '%s\\%s::class,',
            str_repeat(' ', self::INDENT_SIZE * $indentSize),
            $typeClassName,
        );
    }
}
