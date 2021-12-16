<?php

declare (strict_types=1);
class TrTraceExampleBasicClass
{
    function foo()
    {
        return \timglabisch\PhpRtTrace\RtInternalTracer::traceMethodReturn($this->__rt_trace__foo(), 'TrTraceExampleBasicClass', '__rt_trace__foo', 7, 11, '/usr/share/nginx/devel_sf/vendor/timglabisch/php_rt_trace/tests/../example/assign/TrTraceExampleBasicClass.php');
    }
    
    function __rt_trace__foo()
    {
        $a = \timglabisch\PhpRtTrace\RtInternalTracer::traceVariableAssign(0, 'a', 8, 8, '/usr/share/nginx/devel_sf/vendor/timglabisch/php_rt_trace/tests/../example/assign/TrTraceExampleBasicClass.php');
        return $v = \timglabisch\PhpRtTrace\RtInternalTracer::traceVariableAssign($a, 'v', 10, 10, '/usr/share/nginx/devel_sf/vendor/timglabisch/php_rt_trace/tests/../example/assign/TrTraceExampleBasicClass.php');
    }
}