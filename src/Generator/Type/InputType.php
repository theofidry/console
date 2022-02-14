<?php

declare(strict_types=1);

namespace Fidry\Console\Generator\Type;

use Fidry\Console\Generator\Type\ArgumentInput;
use Fidry\Console\Generator\Type\OptionInput;

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

    public function getPsalmTypeDeclaration(): string;

    public function getPhpTypeDeclaration(): string;

    /**
     * @return non-empty-list<class-string<InputType>>
     */
    public function getTypeClassNames(): array;
}
