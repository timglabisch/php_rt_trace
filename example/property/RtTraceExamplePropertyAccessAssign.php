<?php

declare(strict_types=1);

class RtTraceExamplePropertyAccessAssign
{
    private $foo;

    public function getFoo()
    {
        return $this->foo;
    }

    public function setFoo($foo): void
    {
        $this->foo = $foo;
    }
}