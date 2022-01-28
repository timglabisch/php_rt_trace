<?php

declare(strict_types=1);

namespace timglabisch\PhpRtTrace\TraceWriter;

class RtTraceWriterBuffer implements RtTraceWriterInterface
{
    private string $buffer = '';

    public function write(array $arr): void
    {
        try {
            $data = json_encode($arr, JSON_THROW_ON_ERROR);
        } catch (\Throwable $t) {
            $data = @json_encode(['opcode' => 'error', 'msg' => $t]);
        }

        $this->buffer .= $data . "\n";
    }

    public function getBuffer(): string
    {
        return $this->buffer;
    }

}