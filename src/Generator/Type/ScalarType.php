<?php

declare(strict_types=1);

namespace Fidry\Console\Generator\Type;

/**
 * @template ScalarValueType of bool|int|float|string
 * @extends InputType<ScalarValueType>
 */
interface ScalarType extends InputType
{
}
