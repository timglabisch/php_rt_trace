<?php

declare (strict_types=1);
class RtTraceExampleBasicProperty
{
    private $foo;
    public function getFoo()
    {
        return $this->foo;
    }
    public function setFoo($foo) : void
    {
        $this->foo = \timglabisch\PhpRtTrace\RtInternalTracer::tracePropertyAssign($foo, 'RtTraceExampleBasicProperty', 'foo', 16, 16, '/usr/share/nginx/devel_sf/vendor/timglabisch/php_rt_trace/tests/../example/property/RtTraceExampleBasicProperty.php');
    }
}