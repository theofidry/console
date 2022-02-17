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
use Fidry\Console\Internal\Type\TypeFactory;

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

    // The following part is auto-generated.
    // __AUTO_GENERATE_START__

    public function asBoolean(): bool
    {
        $type = TypeFactory::createTypeFromClassNames([
            \Fidry\Console\Internal\Type\BooleanType::class,
        ]);

        return $type->castValue($this->value);
    }

    public function asNullableBoolean(): ?bool
    {
        $type = TypeFactory::createTypeFromClassNames([
            \Fidry\Console\Internal\Type\NullableType::class,
            \Fidry\Console\Internal\Type\BooleanType::class,
        ]);

        return $type->castValue($this->value);
    }

    public function asString(): string
    {
        $type = TypeFactory::createTypeFromClassNames([
            \Fidry\Console\Internal\Type\StringType::class,
        ]);

        return $type->castValue($this->value);
    }

    public function asNullableString(): ?string
    {
        $type = TypeFactory::createTypeFromClassNames([
            \Fidry\Console\Internal\Type\NullableType::class,
            \Fidry\Console\Internal\Type\StringType::class,
        ]);

        return $type->castValue($this->value);
    }

    /**
     * @return list<string>
     */
    public function asStringList(): array
    {
        $type = TypeFactory::createTypeFromClassNames([
            \Fidry\Console\Internal\Type\ListType::class,
            \Fidry\Console\Internal\Type\StringType::class,
        ]);

        return $type->castValue($this->value);
    }

    public function asInteger(): int
    {
        $type = TypeFactory::createTypeFromClassNames([
            \Fidry\Console\Internal\Type\IntegerType::class,
        ]);

        return $type->castValue($this->value);
    }

    public function asNullableInteger(): ?int
    {
        $type = TypeFactory::createTypeFromClassNames([
            \Fidry\Console\Internal\Type\NullableType::class,
            \Fidry\Console\Internal\Type\IntegerType::class,
        ]);

        return $type->castValue($this->value);
    }

    /**
     * @return list<int>
     */
    public function asIntegerList(): array
    {
        $type = TypeFactory::createTypeFromClassNames([
            \Fidry\Console\Internal\Type\ListType::class,
            \Fidry\Console\Internal\Type\IntegerType::class,
        ]);

        return $type->castValue($this->value);
    }

    public function asFloat(): float
    {
        $type = TypeFactory::createTypeFromClassNames([
            \Fidry\Console\Internal\Type\FloatType::class,
        ]);

        return $type->castValue($this->value);
    }

    public function asNullableFloat(): ?float
    {
        $type = TypeFactory::createTypeFromClassNames([
            \Fidry\Console\Internal\Type\NullableType::class,
            \Fidry\Console\Internal\Type\FloatType::class,
        ]);

        return $type->castValue($this->value);
    }

    /**
     * @return list<float>
     */
    public function asFloatList(): array
    {
        $type = TypeFactory::createTypeFromClassNames([
            \Fidry\Console\Internal\Type\ListType::class,
            \Fidry\Console\Internal\Type\FloatType::class,
        ]);

        return $type->castValue($this->value);
    }
    // __AUTO_GENERATE_END__
}
