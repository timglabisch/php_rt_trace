<?php

declare (strict_types=1);
class RtTraceExamplePropertyAccessRead
{
    private $foo;
    public function getFoo()
    {
        return \timglabisch\PhpRtTrace\RtInternalTracer::traceMethodReturn($this->__rt_trace__getFoo(), 'RtTraceExamplePropertyAccessRead', '__rt_trace__getFoo', 9, 12, '/usr/share/nginx/devel_sf/vendor/timglabisch/php_rt_trace/tests/../example/property/RtTraceExamplePropertyAccessRead.php');
    }
    public function setFoo($foo) : void
    {
        $this->__rt_trace__setFoo(\timglabisch\PhpRtTrace\RtInternalTracer::traceMethodParam($foo, 'RtTraceExamplePropertyAccessRead', '__rt_trace__setFoo', 'foo', 0, 14, 14, '/usr/share/nginx/devel_sf/vendor/timglabisch/php_rt_trace/tests/../example/property/RtTraceExamplePropertyAccessRead.php'));
    }
    
    public function __rt_trace__getFoo()
    {
        return \timglabisch\PhpRtTrace\RtInternalTracer::tracePropertyFetch($this->foo, 'RtTraceExamplePropertyAccessRead', 'foo', 11, 11, '/usr/share/nginx/devel_sf/vendor/timglabisch/php_rt_trace/tests/../example/property/RtTraceExamplePropertyAccessRead.php');
    }
    
    public function __rt_trace__setFoo($foo) : void
    {
        $this->foo = \timglabisch\PhpRtTrace\RtInternalTracer::tracePropertyAssign($foo, 'RtTraceExamplePropertyAccessRead', 'foo', 16, 16, '/usr/share/nginx/devel_sf/vendor/timglabisch/php_rt_trace/tests/../example/property/RtTraceExamplePropertyAccessRead.php');
    }
}