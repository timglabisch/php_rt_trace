<?php

declare (strict_types=1);
namespace example\method;

class TrTraceByRef
{
    public function foo()
    {
        return \timglabisch\PhpRtTrace\RtInternalTracer::traceMethodReturn($this->__rt_trace__foo(), 'TrTraceByRef', '__rt_trace__foo', 9, 12, '/usr/share/nginx/devel_sf/vendor/timglabisch/php_rt_trace/tests/../example/method/TrTraceByRef.php');
    }
    
    public function __rt_trace__foo()
    {
        (fn() => array(shuffle($this->a), \timglabisch\PhpRtTrace\RtInternalTracer::tracePropertyFetch($this->a, 'unknown', 'a', 10, 10, '/usr/share/nginx/devel_sf/vendor/timglabisch/php_rt_trace/tests/../example/method/TrTraceByRef.php')))()[0];
        (fn() => array(shuffle($this->a, $this->b, [123], (fn() => 1)()), \timglabisch\PhpRtTrace\RtInternalTracer::tracePropertyFetch($this->a, 'unknown', 'a', 11, 11, '/usr/share/nginx/devel_sf/vendor/timglabisch/php_rt_trace/tests/../example/method/TrTraceByRef.php'), \timglabisch\PhpRtTrace\RtInternalTracer::tracePropertyFetch($this->b, 'unknown', 'b', 11, 11, '/usr/share/nginx/devel_sf/vendor/timglabisch/php_rt_trace/tests/../example/method/TrTraceByRef.php')))()[0];
    }
}