<?php

declare(strict_types=1);

namespace timglabisch\PhpRtTrace\FileIdGenerator;

use timglabisch\PhpRtTrace\FileIdGenerator\RtFileIdGeneratorInterface;

class RtFileIdGeneratorDebug implements RtFileIdGeneratorInterface
{
    public function generateFileId(string $filename)
    {
        return 'RT' . md5($filename);
    }

}