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

use Fidry\Console\Type\TypeFactory;

trait IOGetters
{

    /**
     * @return bool
     */
    public function getBooleanArgument(string $name): bool
    {
        $argument = $this->getArgument($name);

        $type = TypeFactory::createTypeFromClassNames([
            \Fidry\Console\Type\BooleanType::class,
        ]);

        return $type->castValue($argument);
    }

    /**
     * @return null|bool
     */
    public function getNullableBooleanArgument(string $name): ?bool
    {
        $argument = $this->getArgument($name);

        $type = TypeFactory::createTypeFromClassNames([
            \Fidry\Console\Type\NullableType::class,
            \Fidry\Console\Type\BooleanType::class,
        ]);

        return $type->castValue($argument);
    }

    /**
     * @return string
     */
    public function getStringArgument(string $name): string
    {
        $argument = $this->getArgument($name);

        $type = TypeFactory::createTypeFromClassNames([
            \Fidry\Console\Type\StringType::class,
        ]);

        return $type->castValue($argument);
    }

    /**
     * @return null|string
     */
    public function getNullableStringArgument(string $name): ?string
    {
        $argument = $this->getArgument($name);

        $type = TypeFactory::createTypeFromClassNames([
            \Fidry\Console\Type\NullableType::class,
            \Fidry\Console\Type\StringType::class,
        ]);

        return $type->castValue($argument);
    }

    /**
     * @return list<string>
     */
    public function getStringListArgument(string $name): array
    {
        $argument = $this->getArgument($name);

        $type = TypeFactory::createTypeFromClassNames([
            \Fidry\Console\Type\ListType::class,
            \Fidry\Console\Type\StringType::class,
        ]);

        return $type->castValue($argument);
    }

    /**
     * @return int
     */
    public function getIntegerArgument(string $name): int
    {
        $argument = $this->getArgument($name);

        $type = TypeFactory::createTypeFromClassNames([
            \Fidry\Console\Type\IntegerType::class,
        ]);

        return $type->castValue($argument);
    }

    /**
     * @return null|int
     */
    public function getNullableIntegerArgument(string $name): ?int
    {
        $argument = $this->getArgument($name);

        $type = TypeFactory::createTypeFromClassNames([
            \Fidry\Console\Type\NullableType::class,
            \Fidry\Console\Type\IntegerType::class,
        ]);

        return $type->castValue($argument);
    }

    /**
     * @return list<int>
     */
    public function getIntegerListArgument(string $name): array
    {
        $argument = $this->getArgument($name);

        $type = TypeFactory::createTypeFromClassNames([
            \Fidry\Console\Type\ListType::class,
            \Fidry\Console\Type\IntegerType::class,
        ]);

        return $type->castValue($argument);
    }

    /**
     * @return float
     */
    public function getFloatArgument(string $name): float
    {
        $argument = $this->getArgument($name);

        $type = TypeFactory::createTypeFromClassNames([
            \Fidry\Console\Type\FloatType::class,
        ]);

        return $type->castValue($argument);
    }

    /**
     * @return null|float
     */
    public function getNullableFloatArgument(string $name): ?float
    {
        $argument = $this->getArgument($name);

        $type = TypeFactory::createTypeFromClassNames([
            \Fidry\Console\Type\NullableType::class,
            \Fidry\Console\Type\FloatType::class,
        ]);

        return $type->castValue($argument);
    }

    /**
     * @return list<float>
     */
    public function getFloatListArgument(string $name): array
    {
        $argument = $this->getArgument($name);

        $type = TypeFactory::createTypeFromClassNames([
            \Fidry\Console\Type\ListType::class,
            \Fidry\Console\Type\FloatType::class,
        ]);

        return $type->castValue($argument);
    }

    /**
     * @return bool
     */
    public function getBooleanOption(string $name): bool
    {
        $option = $this->getOption($name);

        $type = TypeFactory::createTypeFromClassNames([
            \Fidry\Console\Type\BooleanType::class,
        ]);

        return $type->castValue($option);
    }

    /**
     * @return null|bool
     */
    public function getNullableBooleanOption(string $name): ?bool
    {
        $option = $this->getOption($name);

        $type = TypeFactory::createTypeFromClassNames([
            \Fidry\Console\Type\NullableType::class,
            \Fidry\Console\Type\BooleanType::class,
        ]);

        return $type->castValue($option);
    }

    /**
     * @return string
     */
    public function getStringOption(string $name): string
    {
        $option = $this->getOption($name);

        $type = TypeFactory::createTypeFromClassNames([
            \Fidry\Console\Type\StringType::class,
        ]);

        return $type->castValue($option);
    }

    /**
     * @return null|string
     */
    public function getNullableStringOption(string $name): ?string
    {
        $option = $this->getOption($name);

        $type = TypeFactory::createTypeFromClassNames([
            \Fidry\Console\Type\NullableType::class,
            \Fidry\Console\Type\StringType::class,
        ]);

        return $type->castValue($option);
    }

    /**
     * @return list<string>
     */
    public function getStringListOption(string $name): array
    {
        $option = $this->getOption($name);

        $type = TypeFactory::createTypeFromClassNames([
            \Fidry\Console\Type\ListType::class,
            \Fidry\Console\Type\StringType::class,
        ]);

        return $type->castValue($option);
    }

    /**
     * @return int
     */
    public function getIntegerOption(string $name): int
    {
        $option = $this->getOption($name);

        $type = TypeFactory::createTypeFromClassNames([
            \Fidry\Console\Type\IntegerType::class,
        ]);

        return $type->castValue($option);
    }

    /**
     * @return null|int
     */
    public function getNullableIntegerOption(string $name): ?int
    {
        $option = $this->getOption($name);

        $type = TypeFactory::createTypeFromClassNames([
            \Fidry\Console\Type\NullableType::class,
            \Fidry\Console\Type\IntegerType::class,
        ]);

        return $type->castValue($option);
    }

    /**
     * @return list<int>
     */
    public function getIntegerListOption(string $name): array
    {
        $option = $this->getOption($name);

        $type = TypeFactory::createTypeFromClassNames([
            \Fidry\Console\Type\ListType::class,
            \Fidry\Console\Type\IntegerType::class,
        ]);

        return $type->castValue($option);
    }

    /**
     * @return float
     */
    public function getFloatOption(string $name): float
    {
        $option = $this->getOption($name);

        $type = TypeFactory::createTypeFromClassNames([
            \Fidry\Console\Type\FloatType::class,
        ]);

        return $type->castValue($option);
    }

    /**
     * @return null|float
     */
    public function getNullableFloatOption(string $name): ?float
    {
        $option = $this->getOption($name);

        $type = TypeFactory::createTypeFromClassNames([
            \Fidry\Console\Type\NullableType::class,
            \Fidry\Console\Type\FloatType::class,
        ]);

        return $type->castValue($option);
    }

    /**
     * @return list<float>
     */
    public function getFloatListOption(string $name): array
    {
        $option = $this->getOption($name);

        $type = TypeFactory::createTypeFromClassNames([
            \Fidry\Console\Type\ListType::class,
            \Fidry\Console\Type\FloatType::class,
        ]);

        return $type->castValue($option);
    }

}