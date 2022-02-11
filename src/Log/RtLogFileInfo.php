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
            'opcode' => RtInternalTracer::OPCODE_FILEINFO,
            'id' => $this->id,
            'filename' => $this->filename,
            'hash' => $this->hash,
        ], JSON_THROW_ON_ERROR);
    }

    public static function tryFromArray(array $arr): ?self {
        if ($arr['opcode'] !== RtInternalTracer::OPCODE_FILEINFO) {
            return null;
        }

        return new self($arr['id'], $arr['filename'], $arr['hash']);
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