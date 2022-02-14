<?php

declare(strict_types=1);

namespace Fidry\Console\Generator\Type;

use Fidry\Console\Command\ConsoleAssert;

/**
 * @implements ScalarType<string>
 */
final class StringType implements ScalarType
{
    public function castValue($value): string
    {
        ConsoleAssert::string($value);

        return $value;
    }

    public function getPsalmTypeDeclaration(): string
    {
        return 'string';
    }

    public function getPhpTypeDeclaration(): string
    {
        return 'string';
    }

    public function getTypeClassNames(): array
    {
        return [self::class];
    }
}
