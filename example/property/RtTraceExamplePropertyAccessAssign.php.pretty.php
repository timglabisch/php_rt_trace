<?php

declare (strict_types=1);
namespace example\property;

define('__RT77f42eb33b29231bfd26f7b338009925', array('RT77f42eb33b29231bfd26f7b338009925', '{"opcode":6,"id":"RT77f42eb33b29231bfd26f7b338009925","filename":"\\/Users\\/timglabisch\\/proj\\/php\\/php_rt_trace\\/tests\\/..\\/example\\/property\\/RtTraceExamplePropertyAccessAssign.php","hash":"b9cf2abb4d4b8c2152bcb4bc6cdde28a"}'));
class RtTraceExamplePropertyAccessAssign
{
    private $foo;
    private int $foo2;
    public function getFoo()
    {
        return \timglabisch\PhpRtTrace\RtInternalTracer::tracePropertyFetch($this->foo, __CLASS__, 'foo', 14, 14, __RT77f42eb33b29231bfd26f7b338009925);
    }
    public function setFoo($foo) : void
    {
        $this->foo = \timglabisch\PhpRtTrace\RtInternalTracer::tracePropertyAssign($foo, __CLASS__, 'foo', 19, 19, __RT77f42eb33b29231bfd26f7b338009925);
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