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

use function array_map;
use Fidry\Console\InputAssert;
use function Safe\sprintf;

/**
 * @template CastedValueType
 * @implements InputType<list<CastedValueType>>
 */
final class ListType implements InputType
{
    /**
     * @var InputType<CastedValueType>
     */
    private InputType $innerType;

    /**
     * @param InputType<CastedValueType> $innerType
     */
    public function __construct(InputType $innerType)
    {
        $this->innerType = $innerType;
    }

    public function castValue($value): array
    {
        InputAssert::assertIsList($value);

        return array_map(
            fn (string $element) => $this->innerType->castValue($element),
            $value,
        );
    }

    public function getTypeClassNames(): array
    {
        return [
            self::class,
            ...$this->innerType->getTypeClassNames(),
        ];
    }

    public function getPsalmTypeDeclaration(): string
    {
        return sprintf(
            'list<%s>',
            $this->innerType->getPsalmTypeDeclaration(),
        );
    }

    public function getPhpTypeDeclaration(): string
    {
        return 'array';
    }
}
