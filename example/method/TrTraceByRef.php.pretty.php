<?php

declare (strict_types=1);
namespace example\method;

class TrTraceByRef
{
    public function foo()
    {
        return \timglabisch\PhpRtTrace\RtInternalTracer::traceMethodReturn($this->__rt_trace__foo(), 'TrTraceByRef', '__rt_trace__foo', 9, 11, '/usr/share/nginx/devel_sf/vendor/timglabisch/php_rt_trace/tests/../example/method/TrTraceByRef.php');
    }
    
    public function __rt_trace__foo()
    {
        $this->a['x'] = 'bar';
    }
}