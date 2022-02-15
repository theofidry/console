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

/*
 * This file is part of the box project.
 *
 * (c) Kevin Herrera <kevin@herrera.io>
 *     Théo Fidry <theo.fidry@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Fidry\Console;

use Fidry\Console\Type\BooleanType;
use Fidry\Console\Type\FloatType;
use Fidry\Console\Type\IntegerType;
use Fidry\Console\Type\ListType;
use Fidry\Console\Type\NullableType;
use Fidry\Console\Type\StringType;

trait IOGetters
{
    public function getBooleanArgument(string $name): bool
    {
        $argument = $this->getArgument($name);

        $type = new BooleanType();

        return $type->castValue($argument);
    }

    public function getNullableBooleanArgument(string $name): ?bool
    {
        $argument = $this->getArgument($name);

        $type = new NullableType(new BooleanType());

        return $type->castValue($argument);
    }

    public function getStringArgument(string $name): string
    {
        $argument = $this->getArgument($name);

        $type = new StringType();

        return $type->castValue($argument);
    }

    public function getNullableStringArgument(string $name): ?string
    {
        $argument = $this->getArgument($name);

        $type = new NullableType(new StringType());

        return $type->castValue($argument);
    }

    /**
     * @return list<string>
     */
    public function getStringListArgument(string $name): array
    {
        $argument = $this->getArgument($name);

        $type = new ListType(new StringType());

        return $type->castValue($argument);
    }

    public function getIntegerArgument(string $name): int
    {
        $argument = $this->getArgument($name);

        $type = new IntegerType();

        return $type->castValue($argument);
    }

    public function getNullableIntegerArgument(string $name): ?int
    {
        $argument = $this->getArgument($name);

        $type = new NullableType(new IntegerType());

        return $type->castValue($argument);
    }

    /**
     * @return list<int>
     */
    public function getIntegerListArgument(string $name): array
    {
        $argument = $this->getArgument($name);

        $type = new ListType(new IntegerType());

        return $type->castValue($argument);
    }

    public function getFloatArgument(string $name): float
    {
        $argument = $this->getArgument($name);

        $type = new FloatType();

        return $type->castValue($argument);
    }

    public function getNullableFloatArgument(string $name): ?float
    {
        $argument = $this->getArgument($name);

        $type = new NullableType(new FloatType());

        return $type->castValue($argument);
    }

    /**
     * @return list<float>
     */
    public function getFloatListArgument(string $name): array
    {
        $argument = $this->getArgument($name);

        $type = new ListType(new FloatType());

        return $type->castValue($argument);
    }

    public function getBooleanOption(string $name): bool
    {
        $option = $this->getOption($name);

        $type = new BooleanType();

        return $type->castValue($option);
    }

    public function getNullableBooleanOption(string $name): ?bool
    {
        $option = $this->getOption($name);

        $type = new NullableType(new BooleanType());

        return $type->castValue($option);
    }

    public function getStringOption(string $name): string
    {
        $option = $this->getOption($name);

        $type = new StringType();

        return $type->castValue($option);
    }

    public function getNullableStringOption(string $name): ?string
    {
        $option = $this->getOption($name);

        $type = new NullableType(new StringType());

        return $type->castValue($option);
    }

    /**
     * @return list<string>
     */
    public function getStringListOption(string $name): array
    {
        $option = $this->getOption($name);

        $type = new ListType(new StringType());

        return $type->castValue($option);
    }

    public function getIntegerOption(string $name): int
    {
        $option = $this->getOption($name);

        $type = new IntegerType();

        return $type->castValue($option);
    }

    public function getNullableIntegerOption(string $name): ?int
    {
        $option = $this->getOption($name);

        $type = new NullableType(new IntegerType());

        return $type->castValue($option);
    }

    /**
     * @return list<int>
     */
    public function getIntegerListOption(string $name): array
    {
        $option = $this->getOption($name);

        $type = new ListType(new IntegerType());

        return $type->castValue($option);
    }

    public function getFloatOption(string $name): float
    {
        $option = $this->getOption($name);

        $type = new FloatType();

        return $type->castValue($option);
    }

    public function getNullableFloatOption(string $name): ?float
    {
        $option = $this->getOption($name);

        $type = new NullableType(new FloatType());

        return $type->castValue($option);
    }

    /**
     * @return list<float>
     */
    public function getFloatListOption(string $name): array
    {
        $option = $this->getOption($name);

        $type = new ListType(new FloatType());

        return $type->castValue($option);
    }
}
