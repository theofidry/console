<?php

declare(strict_types=1);

namespace Fidry\Console\IOGenerator\Type;

use Fidry\Console\Command\ConsoleAssert;

/**
 * @implements Scalar<int>
 */
final class IntegerType implements Scalar
{
    public function castValue($value): int
    {
        ConsoleAssert::integer($value);

        return (int) $value;
    }
}
