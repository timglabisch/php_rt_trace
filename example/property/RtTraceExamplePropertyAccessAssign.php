<?php

declare(strict_types=1);

namespace example\property;

class RtTraceExamplePropertyAccessAssign
{
    private $foo;
    private int $foo2;

    public function getFoo()
    {
        return $this->foo;
    }

    public function setFoo($foo): void
    {
        $this->foo = $foo;
    }

    public function getFoo2(): int
    {
        return $this->foo2;
    }

    public function setFoo2(int $foo2): void
    {
        $this->foo2 = $foo2;
    }
}