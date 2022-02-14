<?php

declare(strict_types=1);

namespace Fidry\Console\Generator\Type;

use Fidry\Console\Command\ConsoleAssert;

/**
 * @implements ScalarType<float>
 */
final class FloatType implements ScalarType
{
    public function castValue($value): float
    {
        ConsoleAssert::numeric($value);

        return (float) $value;
    }

    public function getPsalmTypeDeclaration(): string
    {
        return 'float';
    }

    public function getPhpTypeDeclaration(): string
    {
        return 'float';
    }

    public function getTypeClassNames(): array
    {
        return [self::class];
    }
}
