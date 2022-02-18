<?php

namespace example\property;

class RtTracePropertyAdvancedAccess
{
    private $a = 1;
    private $b = [];

    private function foo() {
        shuffle($this->b);
        shuffle($this->b[0]);
        isset($this->{'b'});
        isset($this->b);
        isset($this->b, $this->a);
        $x = isset($this->b[isset($this->a)]);


        empty($this->b);
        foo($this->b + ['a']); // todo we could trace this the easy way
        $this->a ??= 1;
        $a = $this->a ? 1 : 2;
        $this->{'a'} = 1;
        // todo, is this fine with uninitialized properties?
        $x = $this->a ?? $this->b ?? $this->c ?? null;
    }
}