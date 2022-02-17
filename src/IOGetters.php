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

namespace Fidry\Console;

use Fidry\Console\Internal\Type\TypeFactory;

/**
 * @internal
 */
trait IOGetters
{
    /**
     * @deprecated Will be removed in 0.5.0
     */
    public function getBooleanArgument(string $name): bool
    {
        $argument = $this->getLegacyArgument($name);

        $type = TypeFactory::createTypeFromClassNames([
            \Fidry\Console\Internal\Type\BooleanType::class,
        ]);

        return $type->coerceValue($argument);
    }

    /**
     * @deprecated Will be removed in 0.5.0
     */
    public function getNullableBooleanArgument(string $name): ?bool
    {
        $argument = $this->getLegacyArgument($name);

        $type = TypeFactory::createTypeFromClassNames([
            \Fidry\Console\Internal\Type\NullableType::class,
            \Fidry\Console\Internal\Type\BooleanType::class,
        ]);

        return $type->coerceValue($argument);
    }

    /**
     * @deprecated Will be removed in 0.5.0
     */
    public function getStringArgument(string $name): string
    {
        $argument = $this->getLegacyArgument($name);

        $type = TypeFactory::createTypeFromClassNames([
            \Fidry\Console\Internal\Type\StringType::class,
        ]);

        return $type->coerceValue($argument);
    }

    /**
     * @deprecated Will be removed in 0.5.0
     */
    public function getNullableStringArgument(string $name): ?string
    {
        $argument = $this->getLegacyArgument($name);

        $type = TypeFactory::createTypeFromClassNames([
            \Fidry\Console\Internal\Type\NullableType::class,
            \Fidry\Console\Internal\Type\StringType::class,
        ]);

        return $type->coerceValue($argument);
    }

    /**
     * @return list<string>
     *
     * @deprecated Will be removed in 0.5.0
     */
    public function getStringListArgument(string $name): array
    {
        $argument = $this->getLegacyArgument($name);

        $type = TypeFactory::createTypeFromClassNames([
            \Fidry\Console\Internal\Type\ListType::class,
            \Fidry\Console\Internal\Type\StringType::class,
        ]);

        return $type->coerceValue($argument);
    }

    /**
     * @deprecated Will be removed in 0.5.0
     */
    public function getIntegerArgument(string $name): int
    {
        $argument = $this->getLegacyArgument($name);

        $type = TypeFactory::createTypeFromClassNames([
            \Fidry\Console\Internal\Type\IntegerType::class,
        ]);

        return $type->coerceValue($argument);
    }

    /**
     * @deprecated Will be removed in 0.5.0
     */
    public function getNullableIntegerArgument(string $name): ?int
    {
        $argument = $this->getLegacyArgument($name);

        $type = TypeFactory::createTypeFromClassNames([
            \Fidry\Console\Internal\Type\NullableType::class,
            \Fidry\Console\Internal\Type\IntegerType::class,
        ]);

        return $type->coerceValue($argument);
    }

    /**
     * @return list<int>
     *
     * @deprecated Will be removed in 0.5.0
     */
    public function getIntegerListArgument(string $name): array
    {
        $argument = $this->getLegacyArgument($name);

        $type = TypeFactory::createTypeFromClassNames([
            \Fidry\Console\Internal\Type\ListType::class,
            \Fidry\Console\Internal\Type\IntegerType::class,
        ]);

        return $type->coerceValue($argument);
    }

    /**
     * @deprecated Will be removed in 0.5.0
     */
    public function getFloatArgument(string $name): float
    {
        $argument = $this->getLegacyArgument($name);

        $type = TypeFactory::createTypeFromClassNames([
            \Fidry\Console\Internal\Type\FloatType::class,
        ]);

        return $type->coerceValue($argument);
    }

    /**
     * @deprecated Will be removed in 0.5.0
     */
    public function getNullableFloatArgument(string $name): ?float
    {
        $argument = $this->getLegacyArgument($name);

        $type = TypeFactory::createTypeFromClassNames([
            \Fidry\Console\Internal\Type\NullableType::class,
            \Fidry\Console\Internal\Type\FloatType::class,
        ]);

        return $type->coerceValue($argument);
    }

    /**
     * @return list<float>
     *
     * @deprecated Will be removed in 0.5.0
     */
    public function getFloatListArgument(string $name): array
    {
        $argument = $this->getLegacyArgument($name);

        $type = TypeFactory::createTypeFromClassNames([
            \Fidry\Console\Internal\Type\ListType::class,
            \Fidry\Console\Internal\Type\FloatType::class,
        ]);

        return $type->coerceValue($argument);
    }

    /**
     * @deprecated Will be removed in 0.5.0
     */
    public function getBooleanOption(string $name): bool
    {
        $option = $this->getLegacyOption($name);

        $type = TypeFactory::createTypeFromClassNames([
            \Fidry\Console\Internal\Type\BooleanType::class,
        ]);

        return $type->coerceValue($option);
    }

    /**
     * @deprecated Will be removed in 0.5.0
     */
    public function getNullableBooleanOption(string $name): ?bool
    {
        $option = $this->getLegacyOption($name);

        $type = TypeFactory::createTypeFromClassNames([
            \Fidry\Console\Internal\Type\NullableType::class,
            \Fidry\Console\Internal\Type\BooleanType::class,
        ]);

        return $type->coerceValue($option);
    }

    /**
     * @deprecated Will be removed in 0.5.0
     */
    public function getStringOption(string $name): string
    {
        $option = $this->getLegacyOption($name);

        $type = TypeFactory::createTypeFromClassNames([
            \Fidry\Console\Internal\Type\StringType::class,
        ]);

        return $type->coerceValue($option);
    }

    /**
     * @deprecated Will be removed in 0.5.0
     */
    public function getNullableStringOption(string $name): ?string
    {
        $option = $this->getLegacyOption($name);

        $type = TypeFactory::createTypeFromClassNames([
            \Fidry\Console\Internal\Type\NullableType::class,
            \Fidry\Console\Internal\Type\StringType::class,
        ]);

        return $type->coerceValue($option);
    }

    /**
     * @return list<string>
     *
     * @deprecated Will be removed in 0.5.0
     */
    public function getStringListOption(string $name): array
    {
        $option = $this->getLegacyOption($name);

        $type = TypeFactory::createTypeFromClassNames([
            \Fidry\Console\Internal\Type\ListType::class,
            \Fidry\Console\Internal\Type\StringType::class,
        ]);

        return $type->coerceValue($option);
    }

    /**
     * @deprecated Will be removed in 0.5.0
     */
    public function getIntegerOption(string $name): int
    {
        $option = $this->getLegacyOption($name);

        $type = TypeFactory::createTypeFromClassNames([
            \Fidry\Console\Internal\Type\IntegerType::class,
        ]);

        return $type->coerceValue($option);
    }

    /**
     * @deprecated Will be removed in 0.5.0
     */
    public function getNullableIntegerOption(string $name): ?int
    {
        $option = $this->getLegacyOption($name);

        $type = TypeFactory::createTypeFromClassNames([
            \Fidry\Console\Internal\Type\NullableType::class,
            \Fidry\Console\Internal\Type\IntegerType::class,
        ]);

        return $type->coerceValue($option);
    }

    /**
     * @return list<int>
     *
     * @deprecated Will be removed in 0.5.0
     */
    public function getIntegerListOption(string $name): array
    {
        $option = $this->getLegacyOption($name);

        $type = TypeFactory::createTypeFromClassNames([
            \Fidry\Console\Internal\Type\ListType::class,
            \Fidry\Console\Internal\Type\IntegerType::class,
        ]);

        return $type->coerceValue($option);
    }

    /**
     * @deprecated Will be removed in 0.5.0
     */
    public function getFloatOption(string $name): float
    {
        $option = $this->getLegacyOption($name);

        $type = TypeFactory::createTypeFromClassNames([
            \Fidry\Console\Internal\Type\FloatType::class,
        ]);

        return $type->coerceValue($option);
    }

    /**
     * @deprecated Will be removed in 0.5.0
     */
    public function getNullableFloatOption(string $name): ?float
    {
        $option = $this->getLegacyOption($name);

        $type = TypeFactory::createTypeFromClassNames([
            \Fidry\Console\Internal\Type\NullableType::class,
            \Fidry\Console\Internal\Type\FloatType::class,
        ]);

        return $type->coerceValue($option);
    }

    /**
     * @return list<float>
     *
     * @deprecated Will be removed in 0.5.0
     */
    public function getFloatListOption(string $name): array
    {
        $option = $this->getLegacyOption($name);

        $type = TypeFactory::createTypeFromClassNames([
            \Fidry\Console\Internal\Type\ListType::class,
            \Fidry\Console\Internal\Type\FloatType::class,
        ]);

        return $type->coerceValue($option);
    }
}
