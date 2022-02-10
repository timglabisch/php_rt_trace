<?php

namespace timglabisch\PhpRtTrace\Log;

use timglabisch\PhpRtTrace\RtInternalTracer;

class RtLogFileInfo
{
    public function __construct(
        private string $id,
        private string $filename,
        private string $hash,
    )
    {
    }

    public function serializeToString(): string {
        return json_encode([
            RtInternalTracer::OPCODE_FILEINFO,
            $this->id,
            $this->filename,
            $this->hash,
        ]);
    }

    public function fromString(string $str): self {
        [$opcode, $id, $filename, $hash] = json_decode($str, true);
        if ($opcode !== RtInternalTracer::OPCODE_FILEINFO) {
            throw new \LogicException('invalid opcode');
        }

        return new self($id, $filename, $hash);
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getFilename(): string
    {
        return $this->filename;
    }

    public function getHash(): string
    {
        return $this->hash;
    }
}