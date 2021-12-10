<?php

declare (strict_types=1);
class TrTraceExampleBasicClass
{
    function foo()
    {
        $a = \timglabisch\PhpRtTrace\RtInternalTracer::traceVariableAssign(0, 'a', 8, 8, '/usr/share/nginx/devel_sf/public/../vendor/timglabisch/php_rt_trace/example/assign/TrTraceExampleBasicClass.php');
        return $v = \timglabisch\PhpRtTrace\RtInternalTracer::traceVariableAssign($a, 'v', 10, 10, '/usr/share/nginx/devel_sf/public/../vendor/timglabisch/php_rt_trace/example/assign/TrTraceExampleBasicClass.php');
    }
}