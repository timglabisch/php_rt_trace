<?php

declare(strict_types=1);

namespace timglabisch\PhpRtTrace\TraceWriter;

class RtTraceWriterBuffer implements RtTraceWriterInterface
{
    private array $buffer = [];

    public function write(array $arr): void
    {
        $this->buffer[] = $arr;
    }

    public function getBuffer(): array
    {
        return $this->buffer;
    }

}