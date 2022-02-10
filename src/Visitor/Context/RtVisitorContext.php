<?php

namespace timglabisch\PhpRtTrace\Visitor\Context;

use PhpParser\Node;
use timglabisch\PhpRtTrace\Log\RtLogFileInfo;

class RtVisitorContext
{
    private RtLogFileInfo $fileInfo;
    public function __construct(
        private string $fileId,
        private string $filename,
    ){
        $this->fileInfo = new RtLogFileInfo(
            $this->fileId,
            $this->filename,
            md5_file($this->filename)
        );
    }

    public function getFileId(): string
    {
        return $this->fileId;
    }

    public function getFilename(): string
    {
        return $this->filename;
    }

    public function getFileInfoString(): RtLogFileInfo {
        return $this->fileInfo->serializeToString();
    }

    public function getFileInfoStringAsAstString(): Node {
        return new Node\Scalar\String_($this->fileInfo->serializeToString());
    }

    public function getFileInfoStringAsAstConstFetch(): Node {
        return new Node\Expr\ConstFetch(new Node\Name('__'.$this->getFileId()));
    }

}