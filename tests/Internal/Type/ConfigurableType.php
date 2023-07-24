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

namespace Fidry\Console\Tests\Internal\Type;

use Fidry\Console\Internal\Type\InputType;

final class ConfigurableType implements InputType
{
    /**
     * @param non-empty-list<class-string<InputType>> $typeClassNames
     */
    public function __construct(
        private readonly string $psalmTypeDeclaration,
        private readonly ?string $phpTypeDeclaration,
        private readonly array $typeClassNames = [self::class]
    ) {
    }

    public function coerceValue($value, string $label): mixed
    {
        return $value;
    }

    public function getTypeClassNames(): array
    {
        return $this->typeClassNames;
    }

    public function getPsalmTypeDeclaration(): string
    {
        return $this->psalmTypeDeclaration;
    }

    public function getPhpTypeDeclaration(): ?string
    {
        return $this->phpTypeDeclaration;
    }
}
