<?php

declare(strict_types=1);

namespace timglabisch\PhpRtTrace\TraceWriter;

class RtTraceWriterFile implements RtTraceWriterInterface
{
    private string $buffer = '';

    public function __construct(
        private string $filename,
    )
    {
    }

    public function writeArray(array $arr): void
    {
        try {
            $data = json_encode($arr, JSON_THROW_ON_ERROR);
        } catch (\Throwable $t) {
            $data = @json_encode(['opcode' => 'error', 'msg' => $t]);
        }

        $this->buffer .= $data . "\n";
        $this->flush(true);
    }

    public function writeRaw(string $raw): void
    {
        $this->buffer .= $raw;
        $this->flush(true);
    }

    public function flush(bool $useBuffer = true): void {
        if ($useBuffer) {
            if (strlen($this->buffer) < 5000) {
                return;
            }
        }

        if ($this->buffer === '') {
            return;
        }

        file_put_contents($this->filename, $this->buffer, FILE_APPEND | LOCK_EX);
        $this->buffer = '';
    }

    public function __destruct()
    {
        if ($this->buffer === '') {
            return;
        }

        $this->flush(false);
    }

}