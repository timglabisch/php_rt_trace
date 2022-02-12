<?php

namespace example\property;

class RtTracePropertyAdvancedAccess
{
    private $a = 1;
    private $b = [];

    private function foo() {
        $this->a += 1;
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