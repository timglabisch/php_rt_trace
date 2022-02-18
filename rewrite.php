#!/usr/bin/env php
<?php

ini_set("memory_limit", "-1");
set_time_limit(0);

use \timglabisch\PhpRtTrace\Cli\RtRewrite;

$autoload = __DIR__ . '/vendor/autoload.php';

if (file_exists($autoload)) {
    require $autoload;
}

exit((new RtRewrite($argv))->run());

