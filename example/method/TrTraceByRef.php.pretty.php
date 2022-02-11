<?php

declare (strict_types=1);
namespace example\method;

define('__RT433578cbe7d975166ac33eee925db5c6', array('RT433578cbe7d975166ac33eee925db5c6', '{"opcode":6,"id":"RT433578cbe7d975166ac33eee925db5c6","filename":"\\/usr\\/share\\/nginx\\/devel_sf\\/vendor\\/timglabisch\\/php_rt_trace\\/tests\\/..\\/example\\/method\\/TrTraceByRef.php","hash":"7c0df297438b0ea4795787e5b3a66110"}'));
class TrTraceByRef
{
    public function foo()
    {
        (fn() => array(shuffle($this->a), \timglabisch\PhpRtTrace\RtInternalTracer::tracePropertyFetch($this->a, __CLASS__, 'a', 9, 9, __RT433578cbe7d975166ac33eee925db5c6)))()[0];
        (fn() => array(shuffle($this->a, $this->b, [123], (fn() => 1)()), \timglabisch\PhpRtTrace\RtInternalTracer::tracePropertyFetch($this->a, __CLASS__, 'a', 10, 10, __RT433578cbe7d975166ac33eee925db5c6), \timglabisch\PhpRtTrace\RtInternalTracer::tracePropertyFetch($this->b, __CLASS__, 'b', 10, 10, __RT433578cbe7d975166ac33eee925db5c6)))()[0];
        $this->a['x'] = 'bar';
    }
}