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
use Fidry\Console\Internal\Type\NaturalRangeType;
use Fidry\Console\Internal\Type\StringChoiceType;
use Fidry\Console\Internal\Type\TypeFactory;
use function Safe\sprintf;

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
    private string $label;

    /**
     * @param ArgumentInput|OptionInput $value
     */
    private function __construct($value, string $label)
    {
        $this->value = $value;
        $this->label = $label;
    }

    /**
     * @param ArgumentInput $argument
     */
    public static function fromArgument($argument, string $name): self
    {
        InputAssert::assertIsValidArgumentType($argument, $name);

        return new self(
            $argument,
            sprintf(
                'the argument "%s"',
                $name,
            ),
        );
    }

    /**
     * @param OptionInput $option
     */
    public static function fromOption($option, string $name): self
    {
        InputAssert::assertIsValidOptionType($option, $name);

        return new self(
            $option,
            sprintf(
                'the option "%s"',
                $name,
            ),
        );
    }

    /**
     * @param list<string> $choices
     */
    public function asStringChoice(array $choices): string
    {
        return (new StringChoiceType($choices))->coerceValue(
            $this->value,
            $this->label,
        );
    }

    /**
     * @psalm-suppress MoreSpecificReturnType
     *
     * @param positive-int|0 $min
     * @param positive-int|0 $max
     *
     * @return positive-int|0
     */
    public function asNaturalWithinRange(int $min, int $max): int
    {
        /** @psalm-suppress LessSpecificReturnStatement */
        return (new NaturalRangeType($min, $max))->coerceValue(
            $this->value,
            $this->label,
        );
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

        return $type->coerceValue($this->value, $this->label);
    }

    public function asBoolean(): bool
    {
        $type = TypeFactory::createTypeFromClassNames([
            \Fidry\Console\Internal\Type\BooleanType::class,
        ]);

        return $type->coerceValue($this->value, $this->label);
    }

    public function asNullableBoolean(): ?bool
    {
        $type = TypeFactory::createTypeFromClassNames([
            \Fidry\Console\Internal\Type\NullableType::class,
            \Fidry\Console\Internal\Type\BooleanType::class,
        ]);

        return $type->coerceValue($this->value, $this->label);
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

        return $type->coerceValue($this->value, $this->label);
    }

    /**
     * @return non-empty-list<bool>
     */
    public function asBooleanNonEmptyList(): array
    {
        $type = TypeFactory::createTypeFromClassNames([
            \Fidry\Console\Internal\Type\NonEmptyListType::class,
            \Fidry\Console\Internal\Type\BooleanType::class,
        ]);

        return $type->coerceValue($this->value, $this->label);
    }

    /**
     * @return positive-int|0
     */
    public function asNatural(): int
    {
        $type = TypeFactory::createTypeFromClassNames([
            \Fidry\Console\Internal\Type\NaturalType::class,
        ]);

        return $type->coerceValue($this->value, $this->label);
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

        return $type->coerceValue($this->value, $this->label);
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

        return $type->coerceValue($this->value, $this->label);
    }

    /**
     * @return non-empty-list<positive-int|0>
     */
    public function asNaturalNonEmptyList(): array
    {
        $type = TypeFactory::createTypeFromClassNames([
            \Fidry\Console\Internal\Type\NonEmptyListType::class,
            \Fidry\Console\Internal\Type\NaturalType::class,
        ]);

        return $type->coerceValue($this->value, $this->label);
    }

    /**
     * @return positive-int
     */
    public function asPositiveInteger(): int
    {
        $type = TypeFactory::createTypeFromClassNames([
            \Fidry\Console\Internal\Type\PositiveIntegerType::class,
        ]);

        return $type->coerceValue($this->value, $this->label);
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

        return $type->coerceValue($this->value, $this->label);
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

        return $type->coerceValue($this->value, $this->label);
    }

    /**
     * @return non-empty-list<positive-int>
     */
    public function asPositiveIntegerNonEmptyList(): array
    {
        $type = TypeFactory::createTypeFromClassNames([
            \Fidry\Console\Internal\Type\NonEmptyListType::class,
            \Fidry\Console\Internal\Type\PositiveIntegerType::class,
        ]);

        return $type->coerceValue($this->value, $this->label);
    }

    public function asFloat(): float
    {
        $type = TypeFactory::createTypeFromClassNames([
            \Fidry\Console\Internal\Type\FloatType::class,
        ]);

        return $type->coerceValue($this->value, $this->label);
    }

    public function asNullableFloat(): ?float
    {
        $type = TypeFactory::createTypeFromClassNames([
            \Fidry\Console\Internal\Type\NullableType::class,
            \Fidry\Console\Internal\Type\FloatType::class,
        ]);

        return $type->coerceValue($this->value, $this->label);
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

        return $type->coerceValue($this->value, $this->label);
    }

    /**
     * @return non-empty-list<float>
     */
    public function asFloatNonEmptyList(): array
    {
        $type = TypeFactory::createTypeFromClassNames([
            \Fidry\Console\Internal\Type\NonEmptyListType::class,
            \Fidry\Console\Internal\Type\FloatType::class,
        ]);

        return $type->coerceValue($this->value, $this->label);
    }

    public function asString(): string
    {
        $type = TypeFactory::createTypeFromClassNames([
            \Fidry\Console\Internal\Type\StringType::class,
        ]);

        return $type->coerceValue($this->value, $this->label);
    }

    public function asNullableString(): ?string
    {
        $type = TypeFactory::createTypeFromClassNames([
            \Fidry\Console\Internal\Type\NullableType::class,
            \Fidry\Console\Internal\Type\StringType::class,
        ]);

        return $type->coerceValue($this->value, $this->label);
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

        return $type->coerceValue($this->value, $this->label);
    }

    /**
     * @return non-empty-list<string>
     */
    public function asStringNonEmptyList(): array
    {
        $type = TypeFactory::createTypeFromClassNames([
            \Fidry\Console\Internal\Type\NonEmptyListType::class,
            \Fidry\Console\Internal\Type\StringType::class,
        ]);

        return $type->coerceValue($this->value, $this->label);
    }

    /**
     * @return non-empty-string
     */
    public function asNonEmptyString(): string
    {
        $type = TypeFactory::createTypeFromClassNames([
            \Fidry\Console\Internal\Type\NonEmptyStringType::class,
        ]);

        return $type->coerceValue($this->value, $this->label);
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

        return $type->coerceValue($this->value, $this->label);
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

        return $type->coerceValue($this->value, $this->label);
    }

    /**
     * @return non-empty-list<non-empty-string>
     */
    public function asNonEmptyStringNonEmptyList(): array
    {
        $type = TypeFactory::createTypeFromClassNames([
            \Fidry\Console\Internal\Type\NonEmptyListType::class,
            \Fidry\Console\Internal\Type\NonEmptyStringType::class,
        ]);

        return $type->coerceValue($this->value, $this->label);
    }

    public function asUntrimmedString(): string
    {
        $type = TypeFactory::createTypeFromClassNames([
            \Fidry\Console\Internal\Type\UntrimmedStringType::class,
        ]);

        return $type->coerceValue($this->value, $this->label);
    }

    public function asNullableUntrimmedString(): ?string
    {
        $type = TypeFactory::createTypeFromClassNames([
            \Fidry\Console\Internal\Type\NullableType::class,
            \Fidry\Console\Internal\Type\UntrimmedStringType::class,
        ]);

        return $type->coerceValue($this->value, $this->label);
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

        return $type->coerceValue($this->value, $this->label);
    }

    /**
     * @return non-empty-list<string>
     */
    public function asUntrimmedStringNonEmptyList(): array
    {
        $type = TypeFactory::createTypeFromClassNames([
            \Fidry\Console\Internal\Type\NonEmptyListType::class,
            \Fidry\Console\Internal\Type\UntrimmedStringType::class,
        ]);

        return $type->coerceValue($this->value, $this->label);
    }

    /**
     * @return null|non-empty-string
     */
    public function asNullOrNonEmptyString(): ?string
    {
        $type = TypeFactory::createTypeFromClassNames([
            \Fidry\Console\Internal\Type\NullOrNonEmptyStringType::class,
        ]);

        return $type->coerceValue($this->value, $this->label);
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

        return $type->coerceValue($this->value, $this->label);
    }

    /**
     * @return non-empty-list<null|non-empty-string>
     */
    public function asNullOrNonEmptyStringNonEmptyList(): array
    {
        $type = TypeFactory::createTypeFromClassNames([
            \Fidry\Console\Internal\Type\NonEmptyListType::class,
            \Fidry\Console\Internal\Type\NullOrNonEmptyStringType::class,
        ]);

        return $type->coerceValue($this->value, $this->label);
    }
    // __AUTO_GENERATE_END__
}
