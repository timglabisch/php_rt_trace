<?php

declare (strict_types=1);
namespace example\property;

define('__RT62062118e621b', array('RT62062118e621b', '[6,"RT62062118e621b","\\/usr\\/share\\/nginx\\/devel_sf\\/vendor\\/timglabisch\\/php_rt_trace\\/tests\\/..\\/example\\/property\\/RtTraceExamplePropertyAccessAssign.php","1efcf6cd49bf8ae3436eab2c6b5abcdf"]'));
class RtTraceExamplePropertyAccessAssign
{
    private $foo;
    public function getFoo()
    {
        return \timglabisch\PhpRtTrace\RtInternalTracer::tracePropertyFetch($this->foo, 'example\\property\\RtTraceExamplePropertyAccessAssign', 'foo', 13, 13, __RT62062118e621b);
    }
    public function setFoo($foo) : void
    {
        $this->foo = \timglabisch\PhpRtTrace\RtInternalTracer::tracePropertyAssign($foo, 'example\\property\\RtTraceExamplePropertyAccessAssign', 'foo', 18, 18, __RT62062118e621b);
    }
}