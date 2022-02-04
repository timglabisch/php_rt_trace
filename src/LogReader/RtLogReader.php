<?php

declare(strict_types=1);

namespace timglabisch\PhpRtTrace\LogReader;

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

            while (($line = fgets($stream)) !== false) {
                foreach ($this->collectors as $collector) {
                    if ($collector->looksInteresting($line)) {
                        $collector->visit(json_decode($line, true));
                    }
                }
            }

            @fclose($stream);
        }
    }
}