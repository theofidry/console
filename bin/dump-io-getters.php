#!/usr/bin/env php
<?php

declare(strict_types=1);

use Fidry\Console\Generator\IOGettersGenerator;

require __DIR__.'/../vendor/autoload.php';

IOGettersGenerator::generate();
