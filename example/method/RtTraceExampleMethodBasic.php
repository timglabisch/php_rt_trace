<?php

declare(strict_types=1);

class RtTraceExampleMethodBasic
{
    function foo($a, int $b): void {
        $this->fooBar($a, $b);
    }

    #[Foo]
    function fooMixed($a, $b): mixed {
        return $this->fooBar($a, $b);
    }

    function fooBar($a, $b): mixed {
        return $a;
    }
}