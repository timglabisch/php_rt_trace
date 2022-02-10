<?php

declare (strict_types=1);
namespace example\property;

define('__RT62058ec00e644', array('RT62058ec00e644', '[6,"RT62058ec00e644","\\/Users\\/timglabisch\\/proj\\/php\\/php_rt_trace\\/tests\\/..\\/example\\/property\\/RtTraceExamplePropertyAccessRead.php","c92ffe20db90e0d68161150c52d17394"]'));
class RtTraceExamplePropertyAccessRead
{
    private $foo;
    public function getFoo()
    {
        return \timglabisch\PhpRtTrace\RtInternalTracer::traceMethodReturn($this->__rt_trace__getFoo(), 'example\\property\\RtTraceExamplePropertyAccessRead', '__rt_trace__getFoo', 11, 14, __RT62058ec00e644);
    }
    public function setFoo($foo) : void
    {
        $this->__rt_trace__setFoo(\timglabisch\PhpRtTrace\RtInternalTracer::traceMethodParam($foo, 'example\\property\\RtTraceExamplePropertyAccessRead', '__rt_trace__setFoo', 'foo', 0, 16, 16, '/Users/timglabisch/proj/php/php_rt_trace/tests/../example/property/RtTraceExamplePropertyAccessRead.php'));
    }
    
    public function __rt_trace__getFoo()
    {
        return \timglabisch\PhpRtTrace\RtInternalTracer::tracePropertyFetch($this->foo, 'example\\property\\RtTraceExamplePropertyAccessRead', 'foo', 13, 13, __RT62058ec00e644);
    }
    
    public function __rt_trace__setFoo($foo) : void
    {
        $this->foo = \timglabisch\PhpRtTrace\RtInternalTracer::tracePropertyAssign($foo, 'example\\property\\RtTraceExamplePropertyAccessRead', 'foo', 18, 18, __RT62058ec00e644);
    }
}