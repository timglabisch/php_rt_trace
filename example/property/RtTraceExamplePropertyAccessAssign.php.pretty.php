<?php

declare (strict_types=1);
namespace example\property;

define('__RT8fa9491bd04575826f16a9dd83e89bc5', array('RT8fa9491bd04575826f16a9dd83e89bc5', '{"opcode":6,"id":"RT8fa9491bd04575826f16a9dd83e89bc5","filename":"\\/usr\\/share\\/nginx\\/devel_sf\\/vendor\\/timglabisch\\/php_rt_trace\\/tests\\/..\\/example\\/property\\/RtTraceExamplePropertyAccessAssign.php","hash":"b9cf2abb4d4b8c2152bcb4bc6cdde28a"}'));
class RtTraceExamplePropertyAccessAssign
{
    private $foo;
    private int $foo2;
    public function getFoo()
    {
        return \timglabisch\PhpRtTrace\RtInternalTracer::tracePropertyFetch($this->foo, __CLASS__, 'foo', 14, 14, __RT8fa9491bd04575826f16a9dd83e89bc5);
    }
    public function setFoo($foo) : void
    {
        $this->foo = \timglabisch\PhpRtTrace\RtInternalTracer::tracePropertyAssign($foo, __CLASS__, 'foo', 19, 19, __RT8fa9491bd04575826f16a9dd83e89bc5);
    }
    public function getFoo2() : int
    {
        return $this->foo2;
    }
    public function setFoo2(int $foo2) : void
    {
        $this->foo2 = $foo2;
    }
}