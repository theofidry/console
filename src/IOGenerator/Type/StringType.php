<?php

declare(strict_types=1);

namespace Fidry\Console\IOGenerator\Type;

use Fidry\Console\Command\ConsoleAssert;

/**
 * @implements Scalar<string>
 */
final class StringType implements Scalar
{
    public function castValue($value): self
    {
        ConsoleAssert::string($value);

        return $value;
    }
}
