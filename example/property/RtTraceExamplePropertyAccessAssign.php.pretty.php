<?php

declare (strict_types=1);
namespace example\property;

class RtTraceExamplePropertyAccessAssign
{
    private $foo;
    public function getFoo()
    {
        return \timglabisch\PhpRtTrace\RtInternalTracer::traceMethodReturn($this->__rt_trace__getFoo(), 'example\\property\\RtTraceExamplePropertyAccessAssign', '__rt_trace__getFoo', 11, 14, '/usr/share/nginx/devel_sf/vendor/timglabisch/php_rt_trace/tests/../example/property/RtTraceExamplePropertyAccessAssign.php');
    }
    public function setFoo($foo) : void
    {
        $this->__rt_trace__setFoo(\timglabisch\PhpRtTrace\RtInternalTracer::traceMethodParam($foo, 'example\\property\\RtTraceExamplePropertyAccessAssign', '__rt_trace__setFoo', 'foo', 0, 16, 16, '/usr/share/nginx/devel_sf/vendor/timglabisch/php_rt_trace/tests/../example/property/RtTraceExamplePropertyAccessAssign.php'));
    }
    
    public function __rt_trace__getFoo()
    {
        return \timglabisch\PhpRtTrace\RtInternalTracer::tracePropertyFetch($this->foo, 'example\\property\\RtTraceExamplePropertyAccessAssign', 'foo', 13, 13, '/usr/share/nginx/devel_sf/vendor/timglabisch/php_rt_trace/tests/../example/property/RtTraceExamplePropertyAccessAssign.php');
    }
    
    public function __rt_trace__setFoo($foo) : void
    {
        $this->foo = \timglabisch\PhpRtTrace\RtInternalTracer::tracePropertyAssign($foo, 'example\\property\\RtTraceExamplePropertyAccessAssign', 'foo', 18, 18, '/usr/share/nginx/devel_sf/vendor/timglabisch/php_rt_trace/tests/../example/property/RtTraceExamplePropertyAccessAssign.php');
    }
}