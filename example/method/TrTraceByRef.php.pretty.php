<?php

declare (strict_types=1);
namespace example\method;

define('__RT62062118efddc', array('RT62062118efddc', '[6,"RT62062118efddc","\\/usr\\/share\\/nginx\\/devel_sf\\/vendor\\/timglabisch\\/php_rt_trace\\/tests\\/..\\/example\\/method\\/TrTraceByRef.php","7c0df297438b0ea4795787e5b3a66110"]'));
class TrTraceByRef
{
    public function foo()
    {
        (fn() => array(shuffle($this->a), \timglabisch\PhpRtTrace\RtInternalTracer::tracePropertyFetch($this->a, 'example\\method\\TrTraceByRef', 'a', 9, 9, __RT62062118efddc)))()[0];
        (fn() => array(shuffle($this->a, $this->b, [123], (fn() => 1)()), \timglabisch\PhpRtTrace\RtInternalTracer::tracePropertyFetch($this->a, 'example\\method\\TrTraceByRef', 'a', 10, 10, __RT62062118efddc), \timglabisch\PhpRtTrace\RtInternalTracer::tracePropertyFetch($this->b, 'example\\method\\TrTraceByRef', 'b', 10, 10, __RT62062118efddc)))()[0];
        $this->a['x'] = 'bar';
    }
}