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
 * @psalm-import-type ArgumentInput from \Fidry\Console\InputAssert
 * @psalm-import-type OptionInput from \Fidry\Console\InputAssert
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

    /**
     * @return non-empty-list<class-string<InputType>>
     */
    public function getTypeClassNames(): array;
}
