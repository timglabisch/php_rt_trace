<?php

declare(strict_types=1);

namespace timglabisch\PhpRtRrace;

class RtTraceRewriter
{
    public static function Foo() {
        die('foo');
    }
}