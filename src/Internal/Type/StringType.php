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

namespace Fidry\Console\Internal\Type;

use Fidry\Console\Internal\InputAssert;
use function trim;

/**
 * @implements ScalarType<string>
 */
final class StringType implements ScalarType
{
    public function coerceValue(null|bool|string|array $value, string $label): string
    {
        InputAssert::string($value, $label);

        return trim($value);
    }

    public function getTypeClassNames(): array
    {
        return [self::class];
    }

    public function getPsalmTypeDeclaration(): string
    {
        return 'string';
    }

    public function getPhpTypeDeclaration(): ?string
    {
        return 'string';
    }
}
