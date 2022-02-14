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
 * @template ScalarValueType of bool|int|float|string
 * @extends InputType<ScalarValueType>
 */
interface ScalarType extends InputType
{
}
