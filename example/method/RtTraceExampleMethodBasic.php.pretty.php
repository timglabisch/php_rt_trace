<?php

declare (strict_types=1);
define('__RT62062118e25a6', array('RT62062118e25a6', '[6,"RT62062118e25a6","\\/usr\\/share\\/nginx\\/devel_sf\\/vendor\\/timglabisch\\/php_rt_trace\\/tests\\/..\\/example\\/method\\/RtTraceExampleMethodBasic.php","6ef4423a3ee07fdff4b7fc208c063e9a"]'));
class RtTraceExampleMethodBasic
{
    function foo($a, int $b) : void
    {
        $this->fooBar($a, $b);
    }
    #[\Foo]
    function fooMixed($a, $b) : mixed
    {
        return $this->fooBar($a, $b);
    }
    function fooBar($a, $b) : mixed
    {
        return $a;
    }
}