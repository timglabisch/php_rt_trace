<?php

declare (strict_types=1);
namespace example\method;

define('__RT637c4b150af92e791e7e5619e828e331', array('RT637c4b150af92e791e7e5619e828e331', '{"opcode":6,"id":"RT637c4b150af92e791e7e5619e828e331","filename":"\\/Users\\/timglabisch\\/proj\\/php\\/php_rt_trace\\/tests\\/..\\/example\\/method\\/TrTraceByRef.php","hash":"7c0df297438b0ea4795787e5b3a66110"}'));
class TrTraceByRef
{
    public function foo()
    {
        (fn() => array(shuffle($this->a), \timglabisch\PhpRtTrace\RtInternalTracer::tracePropertyFetch($this->a, __CLASS__, 'a', 9, 9, __RT637c4b150af92e791e7e5619e828e331)))()[0];
        (fn() => array(shuffle($this->a, $this->b, [123], (fn() => 1)()), \timglabisch\PhpRtTrace\RtInternalTracer::tracePropertyFetch($this->a, __CLASS__, 'a', 10, 10, __RT637c4b150af92e791e7e5619e828e331), \timglabisch\PhpRtTrace\RtInternalTracer::tracePropertyFetch($this->b, __CLASS__, 'b', 10, 10, __RT637c4b150af92e791e7e5619e828e331)))()[0];
        $this->a['x'] = 'bar';
    }
}