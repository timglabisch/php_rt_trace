<?php

declare(strict_types=1);

namespace timglabisch\PhpRtTrace\TraceWriter;

class RtTraceWriterFile implements RtTraceWriterInterface
{
    public function __construct(
        private string $filename,
    )
    {
    }

    public function write(array $arr): void
    {
        try {
            $data = json_encode($arr, JSON_THROW_ON_ERROR);
        } catch (\Throwable $t) {
            $data = @json_encode(['opcode' => 'error', 'msg' => $t]);
        }

        file_put_contents($this->filename, $data . "\n", FILE_APPEND | LOCK_EX);
    }
}