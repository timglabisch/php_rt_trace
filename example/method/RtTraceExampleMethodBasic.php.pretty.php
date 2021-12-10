<?php

declare (strict_types=1);
class RtTraceExampleMethodBasic
{
    function foo($a, int $b) : void
    {
        $this->__rt_trace__foo(timglabisch\PhpRtTrace\RtInternalTracer::traceMethodParam($a, 'RtTraceExampleMethodBasic', 'foo', 'a', 0, 7, 7, '/usr/share/nginx/devel_sf/public/../vendor/timglabisch/php_rt_trace/example/method/RtTraceExampleMethodBasic.php'), timglabisch\PhpRtTrace\RtInternalTracer::traceMethodParam($b, 'RtTraceExampleMethodBasic', 'foo', 'b', 1, 7, 7, '/usr/share/nginx/devel_sf/public/../vendor/timglabisch/php_rt_trace/example/method/RtTraceExampleMethodBasic.php'));
    }
    function fooMixed($a, $b) : mixed
    {
        return $this->__rt_trace__fooMixed(timglabisch\PhpRtTrace\RtInternalTracer::traceMethodParam($a, 'RtTraceExampleMethodBasic', 'fooMixed', 'a', 0, 11, 11, '/usr/share/nginx/devel_sf/public/../vendor/timglabisch/php_rt_trace/example/method/RtTraceExampleMethodBasic.php'), timglabisch\PhpRtTrace\RtInternalTracer::traceMethodParam($b, 'RtTraceExampleMethodBasic', 'fooMixed', 'b', 1, 11, 11, '/usr/share/nginx/devel_sf/public/../vendor/timglabisch/php_rt_trace/example/method/RtTraceExampleMethodBasic.php'));
    }
    function fooBar($a, $b) : mixed
    {
        return $this->__rt_trace__fooBar(timglabisch\PhpRtTrace\RtInternalTracer::traceMethodParam($a, 'RtTraceExampleMethodBasic', 'fooBar', 'a', 0, 15, 15, '/usr/share/nginx/devel_sf/public/../vendor/timglabisch/php_rt_trace/example/method/RtTraceExampleMethodBasic.php'), timglabisch\PhpRtTrace\RtInternalTracer::traceMethodParam($b, 'RtTraceExampleMethodBasic', 'fooBar', 'b', 1, 15, 15, '/usr/share/nginx/devel_sf/public/../vendor/timglabisch/php_rt_trace/example/method/RtTraceExampleMethodBasic.php'));
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