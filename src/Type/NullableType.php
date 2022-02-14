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

/**
 * @template InnerType
 * @implements InputType<InnerType|null>
 */
final class NullableType implements InputType
{
    /**
     * @var InputType<InnerType>
     */
    private InputType $innerType;

    /**
     * @param InputType<InnerType> $innerType
     */
    public function __construct(InputType $innerType)
    {
        $this->innerType = $innerType;
    }

    public function castValue($value)
    {
        return null === $value ? $value : $this->innerType->castValue($value);
    }
}
