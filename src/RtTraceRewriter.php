<?php

declare(strict_types=1);

namespace timglabisch\PhpRtTrace;

class RtTraceRewriter
{
    public static function Foo() {
        die('foo');
    }
}