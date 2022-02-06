<?php

namespace timglabisch\PhpRtTrace\Log;

use timglabisch\PhpRtTrace\RtInternalTracer;

class RtLogFileInfo
{
    public function __construct(
        private string $id,
        private string $filename,
        private string $sha512,
    )
    {
    }

    public function serializeToString(): string {
        return json_encode([
            RtInternalTracer::OPCODE_FILEINFO,
            $this->id,
            $this->filename,
            $this->sha512,
        ]);
    }
}