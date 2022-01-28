<?php

declare(strict_types=1);

namespace Tests\timglabisch\PhpRtTrace;

use PHPUnit\Framework\TestCase;
use timglabisch\PhpRtTrace\LogReader\Collector\RtPropertyCollector;
use timglabisch\PhpRtTrace\LogReader\RtLogReader;
use timglabisch\PhpRtTrace\RtTraceRewriter;
use timglabisch\PhpRtTrace\TraceWriter\RtTraceWriterBuffer;
use Tests\timglabisch\PhpRtTrace\RewriteFixtures\PhpRtFixtureBasicClass;

class PhpRtTraceAndRewriteTest extends TestCase
{
    public function testTrace() {
        $file = __DIR__ . '/RewriteFixtures/PhpRtFixtureBasicClass.php';

        $rewrite = $pretty = (new RtTraceRewriter())->rewriteFile($file);
        $rewrite = str_replace('<?php', '', $rewrite);

        \timglabisch\PhpRtTrace\RtInternalTracer::$traceWriter = $writer = new RtTraceWriterBuffer();

        eval($rewrite);

        $logReader = RtLogReader::newFromString($writer->getBuffer());
        $logReader->addCollector(new RtPropertyCollector(PhpRtFixtureBasicClass::class));
        $logReader->run();
    }

}