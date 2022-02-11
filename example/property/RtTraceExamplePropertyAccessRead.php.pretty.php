<?php

declare (strict_types=1);
namespace example\property;

define('__RT9e25206ef2d6268e0af96dcd29a3b101', array('RT9e25206ef2d6268e0af96dcd29a3b101', '{"opcode":6,"id":"RT9e25206ef2d6268e0af96dcd29a3b101","filename":"\\/usr\\/share\\/nginx\\/devel_sf\\/vendor\\/timglabisch\\/php_rt_trace\\/tests\\/..\\/example\\/property\\/RtTraceExamplePropertyAccessRead.php","hash":"c92ffe20db90e0d68161150c52d17394"}'));
class RtTraceExamplePropertyAccessRead
{
    private $foo;
    public function getFoo()
    {
        return \timglabisch\PhpRtTrace\RtInternalTracer::tracePropertyFetch($this->foo, __CLASS__, 'foo', 13, 13, __RT9e25206ef2d6268e0af96dcd29a3b101);
    }
    public function setFoo($foo) : void
    {
        $this->foo = \timglabisch\PhpRtTrace\RtInternalTracer::tracePropertyAssign($foo, __CLASS__, 'foo', 18, 18, __RT9e25206ef2d6268e0af96dcd29a3b101);
    }
}