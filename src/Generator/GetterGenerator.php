<?php

declare(strict_types=1);

namespace Fidry\Console\Generator;

use Fidry\Console\Command\ConsoleAssert;
use Fidry\Console\Generator\Type\InputType;
use function array_map;
use function array_pop;
use function array_shift;
use function array_unshift;
use function implode;
use function Safe\sprintf;
use function str_repeat;
use function str_replace;

// TODO: use \FQCN::class instead of string
final class GetterGenerator
{
    private const ARGUMENT_TEMPLATE = <<<'PHP'
    /**
     * @return __PSALM_RETURN_TYPE_PLACEHOLDER__
     */
    public function __METHOD_NAME_PLACEHOLDER__(string $name): __PHP_RETURN_TYPE_PLACEHOLDER__
    {
        $argument = $this->getArgument($name);
    
        $type = TypeFactory::createTypeFromClassNames(
        __TYPE_CLASS_NAMES_PLACEHOLDER__
        );
    
        return $type->castValue($argument);
    }
    PHP;

    private const OPTION_TEMPLATE = <<<'PHP'
    /**
     * @return __PSALM_RETURN_TYPE_PLACEHOLDER__
     */
    public function __METHOD_NAME_PLACEHOLDER__(string $name): __PHP_RETURN_TYPE_PLACEHOLDER__
    {
        $option = $this->getOption($name);
    
        $type = TypeFactory::createTypeFromClassNames([
        __TYPE_CLASS_NAMES_PLACEHOLDER__
        ]);
    
        return $type->castValue($option);
    }
    PHP;

    private const TEMPLATE_MAP = [
        ParameterType::ARGUMENT => self::ARGUMENT_TEMPLATE,
        ParameterType::OPTION => self::OPTION_TEMPLATE,
    ];

    private const INDENT_SIZE = 4;

    /**
     * @param ParameterType::ARGUMENT|ParameterType::OPTION $parameterType $parameterType
     */
    public static function generate(string $parameterType, InputType $type): string
    {
        $typeClassNames = $type->getTypeClassNames();

        return str_replace(
            [
                '__METHOD_NAME_PLACEHOLDER__',
                '__PSALM_RETURN_TYPE_PLACEHOLDER__',
                '__PHP_RETURN_TYPE_PLACEHOLDER__',
                '__TYPE_CLASS_NAMES_PLACEHOLDER__',
            ],
            [
                GetterNameGenerator::generateMethodName(
                    $parameterType,
                    $typeClassNames,
                ),
                $type->getPsalmTypeDeclaration(),
                $type->getPhpTypeDeclaration(),
                self::serializeTypeNames($typeClassNames),
            ],
            self::TEMPLATE_MAP[$parameterType],
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
     * @param positive-int $indentSize
     */
    private static function formatTypeClassName(string $typeClassName, int $indentSize): string
    {
        return sprintf(
            '%s\'%s\',',
            str_repeat(' ', self::INDENT_SIZE * $indentSize),
            $typeClassName,
        );
    }

    private function __construct()
    {
    }
}
