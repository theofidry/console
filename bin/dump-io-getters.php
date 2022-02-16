#!/usr/bin/env php
<?php

declare(strict_types=1);

namespace Fidry\Console;

use Fidry\Console\Generator\GettersGenerator;
use Fidry\Console\Generator\ParameterType;
use Fidry\Console\Generator\TypeMap;
use function Safe\file_put_contents;

require __DIR__.'/../vendor/autoload.php';

const TARGET_PATH = __DIR__.'/../src/IOGetters.php';

$content = GettersGenerator::generate(
    TypeMap::provideTypes(),
    ParameterType::ALL,
);

file_put_contents(TARGET_PATH, $content);
