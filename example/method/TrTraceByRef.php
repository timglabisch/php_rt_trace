<?php

declare(strict_types=1);
namespace example\method;

class TrTraceByRef
{
    public function foo() {
        shuffle($this->a);
        shuffle($this->a, $this->b, [123], (fn() => 1)());
        $this->a['x'] = 'bar';
    }
}