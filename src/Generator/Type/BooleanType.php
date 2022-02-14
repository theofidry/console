<?php

declare(strict_types=1);

namespace Fidry\Console\Generator\Type;

use Fidry\Console\Command\ConsoleAssert;

// TODO: to split into safe & unsafe
/**
 * @implements ScalarType<bool>
 */
final class BooleanType implements ScalarType
{
    public function castValue($value): bool
    {
        ConsoleAssert::assertIsNotArray($value);

        return (bool) $value;
    }

    public function getPsalmTypeDeclaration(): string
    {
        return 'bool';
    }

    public function getPhpTypeDeclaration(): string
    {
        return 'bool';
    }

    public function getTypeClassNames(): array
    {
        return [self::class];
    }
}
