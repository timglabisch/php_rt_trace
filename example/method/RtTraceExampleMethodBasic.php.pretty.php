<?php

declare (strict_types=1);
class RtTraceExampleMethodBasic
{
    function foo($a, int $b) : void
    {
        $this->__rt_trace__foo(\timglabisch\PhpRtTrace\RtInternalTracer::traceMethodParam($a, 'RtTraceExampleMethodBasic', '__rt_trace__foo', 'a', 0, 7, 7, '/usr/share/nginx/devel_sf/vendor/timglabisch/php_rt_trace/tests/../example/method/RtTraceExampleMethodBasic.php'), \timglabisch\PhpRtTrace\RtInternalTracer::traceMethodParam($b, 'RtTraceExampleMethodBasic', '__rt_trace__foo', 'b', 1, 7, 7, '/usr/share/nginx/devel_sf/vendor/timglabisch/php_rt_trace/tests/../example/method/RtTraceExampleMethodBasic.php'));
    }
    #[Foo]
    function fooMixed($a, $b) : mixed
    {
        return \timglabisch\PhpRtTrace\RtInternalTracer::traceMethodReturn($this->__rt_trace__fooMixed(\timglabisch\PhpRtTrace\RtInternalTracer::traceMethodParam($a, 'RtTraceExampleMethodBasic', '__rt_trace__fooMixed', 'a', 0, 12, 12, '/usr/share/nginx/devel_sf/vendor/timglabisch/php_rt_trace/tests/../example/method/RtTraceExampleMethodBasic.php'), \timglabisch\PhpRtTrace\RtInternalTracer::traceMethodParam($b, 'RtTraceExampleMethodBasic', '__rt_trace__fooMixed', 'b', 1, 12, 12, '/usr/share/nginx/devel_sf/vendor/timglabisch/php_rt_trace/tests/../example/method/RtTraceExampleMethodBasic.php')), 'RtTraceExampleMethodBasic', '__rt_trace__fooMixed', 11, 14, '/usr/share/nginx/devel_sf/vendor/timglabisch/php_rt_trace/tests/../example/method/RtTraceExampleMethodBasic.php');
    }
    function fooBar($a, $b) : mixed
    {
        return \timglabisch\PhpRtTrace\RtInternalTracer::traceMethodReturn($this->__rt_trace__fooBar(\timglabisch\PhpRtTrace\RtInternalTracer::traceMethodParam($a, 'RtTraceExampleMethodBasic', '__rt_trace__fooBar', 'a', 0, 16, 16, '/usr/share/nginx/devel_sf/vendor/timglabisch/php_rt_trace/tests/../example/method/RtTraceExampleMethodBasic.php'), \timglabisch\PhpRtTrace\RtInternalTracer::traceMethodParam($b, 'RtTraceExampleMethodBasic', '__rt_trace__fooBar', 'b', 1, 16, 16, '/usr/share/nginx/devel_sf/vendor/timglabisch/php_rt_trace/tests/../example/method/RtTraceExampleMethodBasic.php')), 'RtTraceExampleMethodBasic', '__rt_trace__fooBar', 16, 18, '/usr/share/nginx/devel_sf/vendor/timglabisch/php_rt_trace/tests/../example/method/RtTraceExampleMethodBasic.php');
    }
    
    function __rt_trace__foo($a, int $b) : void
    {
        $this->fooBar($a, $b);
    }
    
    function __rt_trace__fooMixed($a, $b) : mixed
    {
        return $this->fooBar($a, $b);
    }
    
    function __rt_trace__fooBar($a, $b) : mixed
    {
        return $a;
    }
}