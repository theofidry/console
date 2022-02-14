<?php

declare(strict_types=1);

namespace Fidry\Console\Generator\Type;

/**
 * @template InnerType
 * @implements InputType<InnerType|null>
 */
final class NullableType implements InputType, ComposedType
{
    use ComposedTypeAbilities;

    /**
     * @var InputType<InnerType>
     */
    private InputType $innerType;

    /**
     * @param InputType<InnerType> $innerType
     */
    public function __construct(InputType $innerType)
    {
        $this->innerType = $innerType;
    }

    public function castValue($value)
    {
        return null === $value ? $value : $this->innerType->castValue($value);
    }

    public function getPsalmTypeDeclaration(): string
    {
        return 'null|'.$this->innerType->getPsalmTypeDeclaration();
    }

    public function getPhpTypeDeclaration(): string
    {
        return '?'.$this->innerType->getPhpTypeDeclaration();
    }
}
