<?php

declare (strict_types=1);
namespace example\property;

define('__RT5f3db3f6270b148530cce1e27183aee6', array('RT5f3db3f6270b148530cce1e27183aee6', '{"opcode":6,"id":"RT5f3db3f6270b148530cce1e27183aee6","filename":"\\/Users\\/timglabisch\\/proj\\/php\\/php_rt_trace\\/tests\\/..\\/example\\/property\\/RtTraceExamplePropertyAccessRead.php","hash":"c92ffe20db90e0d68161150c52d17394"}'));
class RtTraceExamplePropertyAccessRead
{
    private $foo;
    public function getFoo()
    {
        return \timglabisch\PhpRtTrace\RtInternalTracer::tracePropertyFetch($this->foo, __CLASS__, 'foo', 13, 13, __RT5f3db3f6270b148530cce1e27183aee6);
    }
    public function setFoo($foo) : void
    {
        $this->foo = \timglabisch\PhpRtTrace\RtInternalTracer::tracePropertyAssign($foo, __CLASS__, 'foo', 18, 18, __RT5f3db3f6270b148530cce1e27183aee6);
    }
}