<?php

declare (strict_types=1);
namespace example\method;

class TrTraceByRef
{
    private $a = [];
    public function foo()
    {
        return \timglabisch\PhpRtTrace\RtInternalTracer::traceMethodReturn($this->__rt_trace__foo(), 'TrTraceByRef', '__rt_trace__foo', 11, 13, '/usr/share/nginx/devel_sf/vendor/timglabisch/php_rt_trace/tests/../example/method/TrTraceByRef.php');
    }
    
    public function __rt_trace__foo()
    {
        shuffle($a = \timglabisch\PhpRtTrace\RtInternalTracer::tracePropertyFetch($this->a, 'TrTraceByRef', 'a', 12, 12, '/usr/share/nginx/devel_sf/vendor/timglabisch/php_rt_trace/tests/../example/method/TrTraceByRef.php'));
    }
}