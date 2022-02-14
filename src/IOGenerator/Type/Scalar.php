<?php

declare(strict_types=1);

namespace Fidry\Console\IOGenerator\Type;

/**
 * @template ScalarValueType of bool|int|float|string
 * @extends Type<ScalarValueType>
 */
interface Scalar extends Type
{
}
