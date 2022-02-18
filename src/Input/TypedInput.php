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
    /**
     * @return null|bool|string|list<string>
     */
    public function asRaw()
    {
        $type = TypeFactory::createTypeFromClassNames([
            \Fidry\Console\Internal\Type\RawType::class,
        ]);

        return $type->coerceValue($this->value);
    }

    /**
     * @return null|null|bool|string|list<string>
     */
    public function asNullableRaw(): ?
    {
        $type = TypeFactory::createTypeFromClassNames([
            \Fidry\Console\Internal\Type\NullableType::class,
            \Fidry\Console\Internal\Type\RawType::class,
        ]);

        return $type->coerceValue($this->value);
    }

    /**
     * @return list<null|bool|string|list<string>>
     */
    public function asRawList(): array
    {
        $type = TypeFactory::createTypeFromClassNames([
            \Fidry\Console\Internal\Type\ListType::class,
            \Fidry\Console\Internal\Type\RawType::class,
        ]);

        return $type->coerceValue($this->value);
    }

    /**
     * @return non-empty-list<null|bool|string|list<string>>
     */
    public function asNonEmptyListRaw(): array
    {
        $type = TypeFactory::createTypeFromClassNames([
            \Fidry\Console\Internal\Type\NonEmptyListType::class,
            \Fidry\Console\Internal\Type\RawType::class,
        ]);

        return $type->coerceValue($this->value);
    }


    public function asBoolean(): bool
    {
        $type = TypeFactory::createTypeFromClassNames([
            \Fidry\Console\Internal\Type\BooleanType::class,
        ]);

        return $type->coerceValue($this->value);
    }


    public function asNullableBoolean(): ?bool
    {
        $type = TypeFactory::createTypeFromClassNames([
            \Fidry\Console\Internal\Type\NullableType::class,
            \Fidry\Console\Internal\Type\BooleanType::class,
        ]);

        return $type->coerceValue($this->value);
    }

    /**
     * @return list<bool>
     */
    public function asBooleanList(): array
    {
        $type = TypeFactory::createTypeFromClassNames([
            \Fidry\Console\Internal\Type\ListType::class,
            \Fidry\Console\Internal\Type\BooleanType::class,
        ]);

        return $type->coerceValue($this->value);
    }

    /**
     * @return non-empty-list<bool>
     */
    public function asNonEmptyListBoolean(): array
    {
        $type = TypeFactory::createTypeFromClassNames([
            \Fidry\Console\Internal\Type\NonEmptyListType::class,
            \Fidry\Console\Internal\Type\BooleanType::class,
        ]);

        return $type->coerceValue($this->value);
    }

    /**
     * @return positive-int|0
     */
    public function asNatural(): int
    {
        $type = TypeFactory::createTypeFromClassNames([
            \Fidry\Console\Internal\Type\NaturalType::class,
        ]);

        return $type->coerceValue($this->value);
    }

    /**
     * @return null|positive-int|0
     */
    public function asNullableNatural(): ?int
    {
        $type = TypeFactory::createTypeFromClassNames([
            \Fidry\Console\Internal\Type\NullableType::class,
            \Fidry\Console\Internal\Type\NaturalType::class,
        ]);

        return $type->coerceValue($this->value);
    }

    /**
     * @return list<positive-int|0>
     */
    public function asNaturalList(): array
    {
        $type = TypeFactory::createTypeFromClassNames([
            \Fidry\Console\Internal\Type\ListType::class,
            \Fidry\Console\Internal\Type\NaturalType::class,
        ]);

        return $type->coerceValue($this->value);
    }

    /**
     * @return non-empty-list<positive-int|0>
     */
    public function asNonEmptyListNatural(): array
    {
        $type = TypeFactory::createTypeFromClassNames([
            \Fidry\Console\Internal\Type\NonEmptyListType::class,
            \Fidry\Console\Internal\Type\NaturalType::class,
        ]);

        return $type->coerceValue($this->value);
    }

    /**
     * @return positive-int
     */
    public function asPositiveInteger(): int
    {
        $type = TypeFactory::createTypeFromClassNames([
            \Fidry\Console\Internal\Type\PositiveIntegerType::class,
        ]);

        return $type->coerceValue($this->value);
    }

    /**
     * @return null|positive-int
     */
    public function asNullablePositiveInteger(): ?int
    {
        $type = TypeFactory::createTypeFromClassNames([
            \Fidry\Console\Internal\Type\NullableType::class,
            \Fidry\Console\Internal\Type\PositiveIntegerType::class,
        ]);

        return $type->coerceValue($this->value);
    }

    /**
     * @return list<positive-int>
     */
    public function asPositiveIntegerList(): array
    {
        $type = TypeFactory::createTypeFromClassNames([
            \Fidry\Console\Internal\Type\ListType::class,
            \Fidry\Console\Internal\Type\PositiveIntegerType::class,
        ]);

        return $type->coerceValue($this->value);
    }

    /**
     * @return non-empty-list<positive-int>
     */
    public function asNonEmptyListPositiveInteger(): array
    {
        $type = TypeFactory::createTypeFromClassNames([
            \Fidry\Console\Internal\Type\NonEmptyListType::class,
            \Fidry\Console\Internal\Type\PositiveIntegerType::class,
        ]);

        return $type->coerceValue($this->value);
    }


    public function asFloat(): float
    {
        $type = TypeFactory::createTypeFromClassNames([
            \Fidry\Console\Internal\Type\FloatType::class,
        ]);

        return $type->coerceValue($this->value);
    }


    public function asNullableFloat(): ?float
    {
        $type = TypeFactory::createTypeFromClassNames([
            \Fidry\Console\Internal\Type\NullableType::class,
            \Fidry\Console\Internal\Type\FloatType::class,
        ]);

        return $type->coerceValue($this->value);
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

        return $type->coerceValue($this->value);
    }

    /**
     * @return non-empty-list<float>
     */
    public function asNonEmptyListFloat(): array
    {
        $type = TypeFactory::createTypeFromClassNames([
            \Fidry\Console\Internal\Type\NonEmptyListType::class,
            \Fidry\Console\Internal\Type\FloatType::class,
        ]);

        return $type->coerceValue($this->value);
    }


    public function asString(): string
    {
        $type = TypeFactory::createTypeFromClassNames([
            \Fidry\Console\Internal\Type\StringType::class,
        ]);

        return $type->coerceValue($this->value);
    }


    public function asNullableString(): ?string
    {
        $type = TypeFactory::createTypeFromClassNames([
            \Fidry\Console\Internal\Type\NullableType::class,
            \Fidry\Console\Internal\Type\StringType::class,
        ]);

        return $type->coerceValue($this->value);
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

        return $type->coerceValue($this->value);
    }

    /**
     * @return non-empty-list<string>
     */
    public function asNonEmptyListString(): array
    {
        $type = TypeFactory::createTypeFromClassNames([
            \Fidry\Console\Internal\Type\NonEmptyListType::class,
            \Fidry\Console\Internal\Type\StringType::class,
        ]);

        return $type->coerceValue($this->value);
    }

    /**
     * @return non-empty-string
     */
    public function asNonEmptyString(): string
    {
        $type = TypeFactory::createTypeFromClassNames([
            \Fidry\Console\Internal\Type\NonEmptyStringType::class,
        ]);

        return $type->coerceValue($this->value);
    }

    /**
     * @return null|non-empty-string
     */
    public function asNullableNonEmptyString(): ?string
    {
        $type = TypeFactory::createTypeFromClassNames([
            \Fidry\Console\Internal\Type\NullableType::class,
            \Fidry\Console\Internal\Type\NonEmptyStringType::class,
        ]);

        return $type->coerceValue($this->value);
    }

    /**
     * @return list<non-empty-string>
     */
    public function asNonEmptyStringList(): array
    {
        $type = TypeFactory::createTypeFromClassNames([
            \Fidry\Console\Internal\Type\ListType::class,
            \Fidry\Console\Internal\Type\NonEmptyStringType::class,
        ]);

        return $type->coerceValue($this->value);
    }

    /**
     * @return non-empty-list<non-empty-string>
     */
    public function asNonEmptyListNonEmptyString(): array
    {
        $type = TypeFactory::createTypeFromClassNames([
            \Fidry\Console\Internal\Type\NonEmptyListType::class,
            \Fidry\Console\Internal\Type\NonEmptyStringType::class,
        ]);

        return $type->coerceValue($this->value);
    }


    public function asUntrimmedString(): string
    {
        $type = TypeFactory::createTypeFromClassNames([
            \Fidry\Console\Internal\Type\UntrimmedStringType::class,
        ]);

        return $type->coerceValue($this->value);
    }


    public function asNullableUntrimmedString(): ?string
    {
        $type = TypeFactory::createTypeFromClassNames([
            \Fidry\Console\Internal\Type\NullableType::class,
            \Fidry\Console\Internal\Type\UntrimmedStringType::class,
        ]);

        return $type->coerceValue($this->value);
    }

    /**
     * @return list<string>
     */
    public function asUntrimmedStringList(): array
    {
        $type = TypeFactory::createTypeFromClassNames([
            \Fidry\Console\Internal\Type\ListType::class,
            \Fidry\Console\Internal\Type\UntrimmedStringType::class,
        ]);

        return $type->coerceValue($this->value);
    }

    /**
     * @return non-empty-list<string>
     */
    public function asNonEmptyListUntrimmedString(): array
    {
        $type = TypeFactory::createTypeFromClassNames([
            \Fidry\Console\Internal\Type\NonEmptyListType::class,
            \Fidry\Console\Internal\Type\UntrimmedStringType::class,
        ]);

        return $type->coerceValue($this->value);
    }

    /**
     * @return null|non-empty-string
     */
    public function asNullOrNonEmptyString(): ?string
    {
        $type = TypeFactory::createTypeFromClassNames([
            \Fidry\Console\Internal\Type\NullOrNonEmptyStringType::class,
        ]);

        return $type->coerceValue($this->value);
    }

    /**
     * @return list<null|non-empty-string>
     */
    public function asNullOrNonEmptyStringList(): array
    {
        $type = TypeFactory::createTypeFromClassNames([
            \Fidry\Console\Internal\Type\ListType::class,
            \Fidry\Console\Internal\Type\NullOrNonEmptyStringType::class,
        ]);

        return $type->coerceValue($this->value);
    }

    /**
     * @return non-empty-list<null|non-empty-string>
     */
    public function asNonEmptyListNullOrNonEmptyString(): array
    {
        $type = TypeFactory::createTypeFromClassNames([
            \Fidry\Console\Internal\Type\NonEmptyListType::class,
            \Fidry\Console\Internal\Type\NullOrNonEmptyStringType::class,
        ]);

        return $type->coerceValue($this->value);
    }
    // __AUTO_GENERATE_END__
}
