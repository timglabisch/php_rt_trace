<?php

declare(strict_types=1);

namespace timglabisch\PhpRtTrace\TraceWriter;

interface RtTraceWriterInterface
{
    public function write(array $arr): void;
}