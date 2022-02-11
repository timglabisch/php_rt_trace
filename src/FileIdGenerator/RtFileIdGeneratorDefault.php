<?php

declare(strict_types=1);

namespace timglabisch\PhpRtTrace\FileIdGenerator;

class RtFileIdGeneratorDefault implements RtFileIdGeneratorInterface
{
    public function generateFileId(string $filename)
    {
        return str_replace('.', '', uniqid('RT'));
    }

}