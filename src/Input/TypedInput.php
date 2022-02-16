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

namespace Fidry\Console\Input;

use Fidry\Console\InputAssert;
use Fidry\Console\Internal\Type\BooleanType;
use Fidry\Console\Internal\Type\FloatType;
use Fidry\Console\Internal\Type\IntegerType;
use Fidry\Console\Internal\Type\ListType;
use Fidry\Console\Internal\Type\NullableType;
use Fidry\Console\Internal\Type\StringType;

/**
 * @psalm-import-type ArgumentInput from \Fidry\Console\InputAssert
 * @psalm-import-type OptionInput from \Fidry\Console\InputAssert
 */
final class TypedInput
{
    /**
     * @var ArgumentInput|OptionInput
     */
    private $value;

    /**
     * @param ArgumentInput|OptionInput $value
     */
    private function __construct($value)
    {
        $this->value = $value;
    }

    /**
     * @param ArgumentInput $argument
     */
    public static function fromArgument($argument): self
    {
        InputAssert::assertIsValidArgumentType($argument);

        return new self($argument);
    }

    /**
     * @param OptionInput $option
     */
    public static function fromOption($option): self
    {
        InputAssert::assertIsValidOptionType($option);

        return new self($option);
    }

    public function asBoolean(): bool
    {
        return (new BooleanType())->castValue($this->value);
    }

    public function asNullableBoolean(): ?bool
    {
        return (new NullableType(new BooleanType()))->castValue($this->value);
    }

    public function asInteger(): int
    {
        return (new IntegerType())->castValue($this->value);
    }

    public function asNullableInteger(): ?int
    {
        return (new NullableType(new IntegerType()))->castValue($this->value);
    }

    /**
     * @return list<int>
     */
    public function asIntegerList(): array
    {
        return (new ListType(new IntegerType()))->castValue($this->value);
    }

    public function asFloat(): float
    {
        return (new FloatType())->castValue($this->value);
    }

    public function asNullableFloat(): ?float
    {
        return (new NullableType(new FloatType()))->castValue($this->value);
    }

    /**
     * @return list<float>
     */
    public function asFloatList(): array
    {
        return (new ListType(new FloatType()))->castValue($this->value);
    }

    public function asString(): string
    {
        return (new StringType())->castValue($this->value);
    }

    public function asNullableString(): ?string
    {
        return (new NullableType(new StringType()))->castValue($this->value);
    }

    /**
     * @return list<string>
     */
    public function asStringList(): array
    {
        return (new ListType(new StringType()))->castValue($this->value);
    }
}
