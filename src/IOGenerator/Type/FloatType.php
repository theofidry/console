<?php

declare(strict_types=1);

namespace Fidry\Console\IOGenerator\Type;

use Fidry\Console\Command\ConsoleAssert;

/**
 * @implements Scalar<float>
 */
final class FloatType implements Scalar
{
    public function castValue($value): float
    {
        ConsoleAssert::numeric($value);

        return (float) $value;
    }
}
