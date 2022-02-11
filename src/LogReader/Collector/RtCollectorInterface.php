<?php

declare(strict_types=1);

namespace timglabisch\PhpRtTrace\LogReader\Collector;

use timglabisch\PhpRtTrace\Log\RtLogFileInfo;

interface RtCollectorInterface
{
    public function visit(RtLogFileInfo $fileInfo, array $data): void;
}