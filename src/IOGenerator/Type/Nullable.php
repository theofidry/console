<?php

declare(strict_types=1);

namespace Fidry\Console\IOGenerator\Type;

/**
 * @template ValueType
 */
final class Nullable implements Type
{
    private Type $innerType;

    public function __construct(Type $innerType)
    {
        $this->innerType = $innerType;
    }

    public function castValue($value)
    {
        // TODO: Implement castValue() method.
    }
}
