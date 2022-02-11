<?php

declare(strict_types=1);

namespace example\unsupported;

class RtTraceExampleUnsupportedMagicGetter
{
    private $a = 0;

    public function __set(string $name, $value): void
    {
        $this->x = 0;
        // TODO: Implement __set() method.
    }
}