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
    private array $typeClassNames;
    private string $psalmTypeDeclaration;
    private ?string $phpTypeDeclaration;

    /**
     * @param non-empty-list<class-string<InputType>> $typeClassNames
     */
    public function __construct(
        string $psalmTypeDeclaration,
        ?string $phpTypeDeclaration,
        ?array $typeClassNames = null
    ) {
        $this->psalmTypeDeclaration = $psalmTypeDeclaration;
        $this->phpTypeDeclaration = $phpTypeDeclaration;
        $this->typeClassNames = $typeClassNames ?? [self::class];
    }

    public function coerceValue($value)
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
