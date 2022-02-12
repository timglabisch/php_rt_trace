<?php

namespace example\property;

define('__RTc8d2065678cdd5dec24b0ff5ab3fa72b', array('RTc8d2065678cdd5dec24b0ff5ab3fa72b', '{"opcode":6,"id":"RTc8d2065678cdd5dec24b0ff5ab3fa72b","filename":"\\/Users\\/timglabisch\\/proj\\/php\\/php_rt_trace\\/tests\\/..\\/example\\/property\\/RtTracePropertyAdvancedAccess.php","hash":"b3598072ac0aa8bc2e1a38b6d88c75fe"}'));
class RtTracePropertyAdvancedAccess
{
    private $a = 1;
    private $b = [];
    private function foo()
    {
        \timglabisch\PhpRtTrace\RtInternalTracer::tracePropertyFetch($this->a += 1, __CLASS__, 'a', 11, 11, __RTc8d2065678cdd5dec24b0ff5ab3fa72b);
        /*
        $this->a -= 1;
        $this->a *= 1;
        $this->b['a']['b'];
        shuffle($this->b);
        shuffle($this->b[0]);
        shuffle($this->b + [a]);
        $this->a ??= 1;
        $a = $this->a ? 1 : 2;
        $this->{'a'} = 1;
        */
    }
}