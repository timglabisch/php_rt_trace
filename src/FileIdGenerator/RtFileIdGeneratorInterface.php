<?php

declare(strict_types=1);

namespace timglabisch\PhpRtTrace\FileIdGenerator;

interface RtFileIdGeneratorInterface
{
    public function generateFileId(string $filename);
}