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

namespace Fidry\Console\Tests\IO;

final class TypedInput
{
    /**
     * @param string[]|TypeException $stringArray
     * @param int[]|TypeException    $integerArray
     * @param float[]|TypeException  $floatArray
     */
    public function __construct(
        public readonly bool|TypeException $boolean,
        public readonly null|bool|TypeException $nullableBoolean,
        public readonly string|TypeException $string,
        public readonly null|string|TypeException $nullableString,
        public readonly array|TypeException $stringArray,
        public readonly int|TypeException $integer,
        public readonly null|int|TypeException $nullableInteger,
        public readonly array|TypeException $integerArray,
        public readonly float|TypeException $float,
        public readonly null|float|TypeException $nullableFloat,
        public readonly array|TypeException $floatArray,
    ) {
    }

    public static function createForScalar(
        TypeException $arrayToScalarTypeException,
        bool|TypeException $boolean,
        null|bool|TypeException $nullableBoolean,
        string|TypeException $string,
        null|string|TypeException $nullableString,
        int|TypeException $integer,
        null|int|TypeException $nullableInteger,
        float|TypeException $float,
        null|float|TypeException $nullableFloat,
    ): self {
        return new self(
            $boolean,
            $nullableBoolean,
            $string,
            $nullableString,
            $arrayToScalarTypeException,
            $integer,
            $nullableInteger,
            $arrayToScalarTypeException,
            $float,
            $nullableFloat,
            $arrayToScalarTypeException,
        );
    }

    /**
     * @param string[]|TypeException $stringArray
     * @param int[]|TypeException    $integerArray
     * @param float[]|TypeException  $floatArray
     */
    public static function createForArray(
        TypeException $scalarToArrayTypeException,
        array|TypeException $stringArray,
        array|TypeException $integerArray,
        array|TypeException $floatArray,
    ): self {
        return new self(
            $scalarToArrayTypeException,
            $scalarToArrayTypeException,
            $scalarToArrayTypeException,
            $scalarToArrayTypeException,
            $stringArray,
            $scalarToArrayTypeException,
            $scalarToArrayTypeException,
            $integerArray,
            $scalarToArrayTypeException,
            $scalarToArrayTypeException,
            $floatArray,
        );
    }
}
