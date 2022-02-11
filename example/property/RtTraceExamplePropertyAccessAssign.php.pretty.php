<?php

declare (strict_types=1);
namespace example\property;

define('__RT8fa9491bd04575826f16a9dd83e89bc5', array('RT8fa9491bd04575826f16a9dd83e89bc5', '{"opcode":6,"id":"RT8fa9491bd04575826f16a9dd83e89bc5","filename":"\\/usr\\/share\\/nginx\\/devel_sf\\/vendor\\/timglabisch\\/php_rt_trace\\/tests\\/..\\/example\\/property\\/RtTraceExamplePropertyAccessAssign.php","hash":"1efcf6cd49bf8ae3436eab2c6b5abcdf"}'));
class RtTraceExamplePropertyAccessAssign
{
    private $foo;
    public function getFoo()
    {
        return \timglabisch\PhpRtTrace\RtInternalTracer::tracePropertyFetch($this->foo, __CLASS__, 'foo', 13, 13, __RT8fa9491bd04575826f16a9dd83e89bc5);
    }
    public function setFoo($foo) : void
    {
        $this->foo = \timglabisch\PhpRtTrace\RtInternalTracer::tracePropertyAssign($foo, __CLASS__, 'foo', 18, 18, __RT8fa9491bd04575826f16a9dd83e89bc5);
    }
}