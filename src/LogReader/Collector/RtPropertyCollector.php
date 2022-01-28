<?php

declare(strict_types=1);

namespace timglabisch\PhpRtTrace\LogReader\Collector;

use timglabisch\PhpRtTrace\RtInternalTracer;

class RtPropertyCollector implements RtCollectorInterface
{
    private array $encodedClassNames;
    private array $buffer;

    public function __construct(
        private array $classNames
    )
    {
        $this->encodedClassNames = array_map(
            fn(string $v) => trim(json_encode($v), ""),
            $this->classNames
        );
    }

    public function looksInteresting(string $bytes): bool
    {
        foreach ($this->encodedClassNames as $encodedClassName) {
            if (str_contains($bytes, $encodedClassName)) {
                return true;
            }
        }

        return true;
    }

    public function visit(array $data): void
    {
        if (!in_array($data['opcode'] ?? null, [
            RtInternalTracer::OPCODE_PROPERTY_FETCH,
            RtInternalTracer::OPCODE_PROPERTY_ASSIGN,
        ], true)) {
            return;
        }

        if (!in_array($data['class'], $this->classNames, true)) {
            return;
        }

        $this->buffer[$data['class']] = $this->buffer[$data['class']] ?? [];
        $this->buffer[$data['class']][$data['propertyName']] = $this->buffer[$data['class']][$data['propertyName']] ?? [
            'type' => []
        ];

        foreach ($data['type'] as $type => $count) {
            $this->buffer[$data['class']][$data['propertyName']]['type'][$type] = $this->buffer[$data['class']][$data['propertyName']]['type'][$type] ?? 0;
            $this->buffer[$data['class']][$data['propertyName']]['type'][$type] += $count;
        }

        $a = 0;
    }
}