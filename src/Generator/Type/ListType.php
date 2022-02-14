<?php

declare(strict_types=1);

namespace Fidry\Console\Generator\Type;

use Fidry\Console\Command\ConsoleAssert;
use function array_map;
use function Safe\sprintf;

/**
 * TODO: see if it really needs to contain a scalar type or if it could be anything else
 * @template InnerValueType of bool|int|float|string
 * @template InnerType of ScalarType<InnerValueType>
 * @implements InputType<list<InnerValueType>>
 */
final class ListType implements InputType, ComposedType
{
    use ComposedTypeAbilities;

    /**
     * @var ScalarType<InnerValueType>
     */
    private ScalarType $innerType;

    /**
     * @param ScalarType<InnerValueType> $innerType
     */
    public function __construct(ScalarType $innerType)
    {
        $this->innerType = $innerType;
    }

    public function castValue($value): array
    {
        ConsoleAssert::assertIsList($value);

        return array_map(
            fn (string $element) => $this->innerType->castValue($element),
            $value,
        );
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
