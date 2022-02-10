<?php

declare (strict_types=1);
namespace example\method;

define('__RT62058ec00f047', array('RT62058ec00f047', '[6,"RT62058ec00f047","\\/Users\\/timglabisch\\/proj\\/php\\/php_rt_trace\\/tests\\/..\\/example\\/method\\/TrTraceByRef.php","7c0df297438b0ea4795787e5b3a66110"]'));
class TrTraceByRef
{
    public function foo()
    {
        return \timglabisch\PhpRtTrace\RtInternalTracer::traceMethodReturn($this->__rt_trace__foo(), 'example\\method\\TrTraceByRef', '__rt_trace__foo', 8, 12, __RT62058ec00f047);
    }
    
    public function __rt_trace__foo()
    {
        (fn() => array(shuffle($this->a), \timglabisch\PhpRtTrace\RtInternalTracer::tracePropertyFetch($this->a, 'example\\method\\TrTraceByRef', 'a', 9, 9, __RT62058ec00f047)))()[0];
        (fn() => array(shuffle($this->a, $this->b, [123], (fn() => 1)()), \timglabisch\PhpRtTrace\RtInternalTracer::tracePropertyFetch($this->a, 'example\\method\\TrTraceByRef', 'a', 10, 10, __RT62058ec00f047), \timglabisch\PhpRtTrace\RtInternalTracer::tracePropertyFetch($this->b, 'example\\method\\TrTraceByRef', 'b', 10, 10, __RT62058ec00f047)))()[0];
        $this->a['x'] = 'bar';
    }
}