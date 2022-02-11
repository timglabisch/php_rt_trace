<?php

declare(strict_types=1);

namespace timglabisch\PhpRtTrace\LogReader\Collector;

use timglabisch\PhpRtTrace\Log\RtLogFileInfo;
use timglabisch\PhpRtTrace\LogReader\Dto\RtPropertyTypeMap;
use timglabisch\PhpRtTrace\RtInternalTracer;

class RtPropertyCollector implements RtCollectorInterface
{
    private array $encodedFileNames;
    private array $buffer = [];

    public function __construct(
        private array $fileNames
    )
    {
        $this->encodedFileNames = array_map(
            fn(string $v) => trim(json_encode($v), ""),
            $this->fileNames
        );
    }

    public function visit(RtLogFileInfo $fileInfo, array $data): void
    {
        if (!in_array($data['opcode'] ?? null, [
            RtInternalTracer::OPCODE_PROPERTY_FETCH,
            RtInternalTracer::OPCODE_PROPERTY_ASSIGN,
        ], true)) {
            return;
        }

        if (!in_array($data['file'], $this->fileNames, true)) {
            return;
        }

        $this->buffer[$data['class']] = $this->buffer[$data['class']] ?? [];
        $this->buffer[$data['class']][$data['propertyName']] = $this->buffer[$data['class']][$data['propertyName']] ?? [
            'types' => []
        ];

        foreach ($data['type'] as $type => $count) {
            $this->buffer[$data['class']][$data['propertyName']]['types'][$type] = $this->buffer[$data['class']][$data['propertyName']]['types'][$type] ?? 0;
            $this->buffer[$data['class']][$data['propertyName']]['types'][$type] += $count;
        }
    }

    public function getPropertyTypeMap(): RtPropertyTypeMap {
        return new RtPropertyTypeMap($this->buffer);
    }
}