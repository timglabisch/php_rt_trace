<?php

declare(strict_types=1);

namespace timglabisch\PhpRtTrace\LogReader;

use timglabisch\PhpRtTrace\Log\RtLogFileInfo;
use \timglabisch\PhpRtTrace\LogReader\Collector\RtCollectorInterface;

class RtLogReader
{
    /** @var RtCollectorInterface[] */
    private array $collectors;

    public function __construct(
        private $streams
    )
    {
    }

    public function addCollector(RtCollectorInterface $collector): void {
        $this->collectors[] = $collector;
    }

    public static function newFromString(string $string) : self {
        $stream = fopen('php://memory','r+');
        fwrite($stream, $string);
        rewind($stream);
        return new self([$stream]);
    }

    public function run() {
        foreach ($this->streams as $stream) {

            if ($stream instanceof \SplFileInfo) {
                $stream = fopen($stream->getPathname(), 'rb');

                if (!$stream) {
                    throw new \RuntimeException('could not open file ' . $stream);
                }
            }

            /** @var RtLogFileInfo[] $fileInfos */
            $fileInfos = [];

            while (($line = fgets($stream)) !== false) {
                $decodedLine = json_decode($line, true, 512, JSON_THROW_ON_ERROR);

                if ($tryFileInfo = RtLogFileInfo::tryFromArray($decodedLine)) {
                    $fileInfos[$tryFileInfo->getId()] = $tryFileInfo;
                    continue;
                }

                foreach ($this->collectors as $collector) {
                    $fileInfo = $fileInfos[
                        $decodedLine['file'] ?? throw new \LogicException('line without file')
                    ] ?? throw new \LogicException('could not find file ' . $decodedLine['file']);

                    $collector->visit($fileInfo, $decodedLine);
                }
            }

            @fclose($stream);
        }
    }
}