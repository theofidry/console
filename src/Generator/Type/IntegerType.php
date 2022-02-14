<?php

declare(strict_types=1);

namespace Fidry\Console\Generator\Type;

use Fidry\Console\Command\ConsoleAssert;

/**
 * @implements ScalarType<int>
 */
final class IntegerType implements ScalarType
{
    public function castValue($value): int
    {
        ConsoleAssert::integerString($value);

        return (int) $value;
    }

    public function getPsalmTypeDeclaration(): string
    {
        return 'int';
    }

    public function getPhpTypeDeclaration(): string
    {
        return 'int';
    }

    public function getTypeClassNames(): array
    {
        return [self::class];
    }
}
