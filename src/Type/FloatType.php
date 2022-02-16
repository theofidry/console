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

namespace Fidry\Console\Type;

use Fidry\Console\InputAssert;

/**
 * @implements ScalarType<float>
 */
final class FloatType implements ScalarType
{
    public function castValue($value): float
    {
        InputAssert::numericString($value);

        return (float) $value;
    }

    public function getTypeClassNames(): array
    {
        return [self::class];
    }

    public function getPsalmTypeDeclaration(): string
    {
        return 'float';
    }

    public function getPhpTypeDeclaration(): string
    {
        return 'float';
    }
}
