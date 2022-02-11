<?php

declare (strict_types=1);
define('__RT7b88eddfeb08e2dc8893b2a98c7775d3', array('RT7b88eddfeb08e2dc8893b2a98c7775d3', '{"opcode":6,"id":"RT7b88eddfeb08e2dc8893b2a98c7775d3","filename":"\\/usr\\/share\\/nginx\\/devel_sf\\/vendor\\/timglabisch\\/php_rt_trace\\/tests\\/..\\/example\\/method\\/RtTraceExampleMethodBasic.php","hash":"6ef4423a3ee07fdff4b7fc208c063e9a"}'));
class RtTraceExampleMethodBasic
{
    function foo($a, int $b) : void
    {
        $this->fooBar($a, $b);
    }
    #[Foo]
    function fooMixed($a, $b) : mixed
    {
        return $this->fooBar($a, $b);
    }
    function fooBar($a, $b) : mixed
    {
        return $a;
    }
}