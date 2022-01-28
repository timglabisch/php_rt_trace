<?php

declare(strict_types=1);

namespace timglabisch\PhpRtTrace\LogReader\Collector;

class RtPropertyCollector implements RtCollectorInterface
{
    public function __construct(
        private string $className
    )
    {
    }

    public function looksInteresting(string $bytes): bool
    {
        return str_contains($bytes, $this->className);
    }

    public function visit(array $data): void
    {
        $a = 0;
    }
}