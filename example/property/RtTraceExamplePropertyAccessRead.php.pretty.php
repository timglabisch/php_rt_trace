<?php

declare (strict_types=1);
namespace example\property;

define('__RT6206211904c71', array('RT6206211904c71', '[6,"RT6206211904c71","\\/usr\\/share\\/nginx\\/devel_sf\\/vendor\\/timglabisch\\/php_rt_trace\\/tests\\/..\\/example\\/property\\/RtTraceExamplePropertyAccessRead.php","c92ffe20db90e0d68161150c52d17394"]'));
class RtTraceExamplePropertyAccessRead
{
    private $foo;
    public function getFoo()
    {
        return \timglabisch\PhpRtTrace\RtInternalTracer::tracePropertyFetch($this->foo, 'example\\property\\RtTraceExamplePropertyAccessRead', 'foo', 13, 13, __RT6206211904c71);
    }
    public function setFoo($foo) : void
    {
        $this->foo = \timglabisch\PhpRtTrace\RtInternalTracer::tracePropertyAssign($foo, 'example\\property\\RtTraceExamplePropertyAccessRead', 'foo', 18, 18, __RT6206211904c71);
    }
}