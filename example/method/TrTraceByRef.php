<?php

declare(strict_types=1);

namespace example\method;

class TrTraceByRef
{
    private $a = [];

    public function foo() {
        // todo, muss ersetzt werden durch: $ret = (fn() => [trace($this->a), shuffle($this->a)])()[1];
        $ret = shuffle($this->a);
    }
}