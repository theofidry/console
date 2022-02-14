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
use Fidry\Console\Command\ConsoleAssert;

/**
 * TODO: see if it really needs to contain a scalar type or if it could be anything else.
 *
 * @template InnerValueType of bool|int|float|string
 * @template InnerType of ScalarType<InnerValueType>
 * @implements InputType<list<InnerValueType>>
 */
final class ListType implements InputType
{
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
}
