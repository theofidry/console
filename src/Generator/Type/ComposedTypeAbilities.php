<?php

declare(strict_types=1);

namespace Fidry\Console\Generator\Type;

/**
 * @psalm-require-implements ComposedType
 * @psalm-require-implements InputType
 */
trait ComposedTypeAbilities
{
    public function getTypeClassNames(): array
    {
        return [
            self::class,
            ...$this->innerType->getTypeClassNames(),
        ];
    }

    public function getInnerType(): InputType
    {
        return $this->innerType;
    }
}
