<?php

namespace example\property;

define('__RTcb81f4578ffab93b23262732373c42bd', array('RTcb81f4578ffab93b23262732373c42bd', '{"opcode":6,"id":"RTcb81f4578ffab93b23262732373c42bd","filename":"\\/usr\\/share\\/nginx\\/devel_sf\\/vendor\\/timglabisch\\/php_rt_trace\\/tests\\/..\\/example\\/property\\/RtTracePropertyAdvancedAccess.php","hash":"1aaaa2f59bee41c4c636915067a23bdd"}'));
class RtTracePropertyAdvancedAccess
{
    private $a = 1;
    private $b = [];
    private function foo()
    {
        $this->b &= $this->a;
    }
}