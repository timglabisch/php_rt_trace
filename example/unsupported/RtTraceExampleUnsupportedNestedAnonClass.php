<?php

declare(strict_types=1);

namespace example\unsupported;

class RtTraceExampleUnsupportedNestedClass
{
    public function getFoo() {
        return new class {};
    }
}