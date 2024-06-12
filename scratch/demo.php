<?php

namespace App;

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

$io = new SymfonyStyle($input, $output);
$io = new LaravelStyle extends IO($input, $output);
$io->success();

$styledIo = $styleFactory->create($io);

function foo($styledIo)
