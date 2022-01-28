<?php

declare(strict_types=1);

namespace timglabisch\PhpRtTrace\LogReader;

use \timglabisch\PhpRtTrace\LogReader\Collector\RtCollectorInterface;

class RtLogReader
{
    /** @var RtCollectorInterface[] */
    private array $collectors;

    public function __construct(
        private $stream
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
        return new self($stream);
    }

    public function run() {
        while (($line = fgets($this->stream)) !== false) {
            foreach ($this->collectors as $collector) {
                if ($collector->looksInteresting($line)) {
                    $collector->visit(json_decode($line, true));
                }
            }
        }

    }
}