<?php

declare(strict_types=1);

namespace timglabisch\PhpRtTrace\LogReader\Collector;

interface RtCollectorInterface
{
    public function looksInteresting(string $bytes): bool;

    public function visit(array $data): void;
}