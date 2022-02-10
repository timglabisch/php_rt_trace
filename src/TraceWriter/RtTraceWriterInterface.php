<?php

declare(strict_types=1);

namespace timglabisch\PhpRtTrace\TraceWriter;

interface RtTraceWriterInterface
{
    public function writeArray(array $arr): void;
    public function writeRaw(string $raw): void;
}