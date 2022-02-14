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
 * @psalm-import-type ArgumentInput from \Fidry\Console\Command\ConsoleAssert
 * @psalm-import-type OptionInput from \Fidry\Console\Command\ConsoleAssert
 * @template ValueType
 */
interface InputType
{
    /**
     * @param ArgumentInput|OptionInput $value Valid argument or option value
     *
     * @return ValueType
     */
    public function castValue($value);
}
