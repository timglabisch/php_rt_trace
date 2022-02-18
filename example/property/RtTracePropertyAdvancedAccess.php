<?php

namespace example\property;

class RtTracePropertyAdvancedAccess
{
    private $a = 1;
    private $b = [];

    private function foo() {
        unset($this->b['x']);
        unset($this->b);
        $this->b =& $a;
        $this->b =& $this->a;
        $this->b &= $a;
        $this->b &= $this->a;
        $this->b['x'] = 'a';
        $this->a++;
        $this->a = $this->a++;
        $this->a = $this->a = $this->a++;
        // foo could not get a reference to $this->a because $this->a++ is a statement that you cant pass as a reference.
        foo($this->a++);
        ++$this->a;
        --$this->a;
        $this->b = $this->b[$this->a++][$this->a++];
        $this->a--;
        $this->a += 1;
        $this->a -= 1;
        $this->a *= 1;
        $this->b['a']['b'];
        $this->b['a']['b']++;
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