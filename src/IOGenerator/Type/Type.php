<?php

declare(strict_types=1);

namespace Fidry\Console\IOGenerator\Type;

/**
 * @template ValueType
 */
interface Type
{
    /**
     * @param null|string|string[]|list<string> $value Valid argument or option value
     *
     * @return ValueType
     */
    public function castValue($value);
}
