#!/usr/bin/env php
<?php

use \timglabisch\PhpRtTrace\Cli\RtRewrite;

$autoload = __DIR__ . '/vendor/autoload.php';

if (file_exists($autoload)) {
    require $autoload;
}

exit((new RtRewrite($argv))->run());

