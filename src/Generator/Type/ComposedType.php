<?php

declare(strict_types=1);

namespace Fidry\Console\Generator\Type;

interface ComposedType
{
    public function getInnerType(): InputType;
}
