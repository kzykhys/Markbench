<?php

require __DIR__ . '/../vendor/autoload.php';

$runner = new \Markbench\Runner();
$runner->addDriver(new \Markbench\Driver\CiconiaDriver());
$runner->run();