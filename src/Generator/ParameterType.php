<?php

declare(strict_types=1);

namespace Fidry\Console\Generator;

// TODO: switch to an enum in PHP8.1
final class ParameterType
{
    public const ARGUMENT = 'ARGUMENT';
    public const OPTION = 'OPTION';

    public const ALL = [
        self::ARGUMENT,
        self::OPTION,
    ];

    private function __construct()
    {
    }
}
