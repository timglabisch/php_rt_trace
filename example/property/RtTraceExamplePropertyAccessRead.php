<?php

declare(strict_types=1);

class RtTraceExamplePropertyAccessRead
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