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
        public readonly bool|TypeException|null $nullableBoolean,
        public readonly string|TypeException $string,
        public readonly string|TypeException|null $nullableString,
        public readonly array|TypeException $stringArray,
        public readonly int|TypeException $integer,
        public readonly int|TypeException|null $nullableInteger,
        public readonly array|TypeException $integerArray,
        public readonly float|TypeException $float,
        public readonly float|TypeException|null $nullableFloat,
        public readonly array|TypeException $floatArray,
    ) {
    }

    public static function createForScalar(
        TypeException $arrayToScalarTypeException,
        bool|TypeException $boolean,
        bool|TypeException|null $nullableBoolean,
        string|TypeException $string,
        string|TypeException|null $nullableString,
        int|TypeException $integer,
        int|TypeException|null $nullableInteger,
        float|TypeException $float,
        float|TypeException|null $nullableFloat,
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
