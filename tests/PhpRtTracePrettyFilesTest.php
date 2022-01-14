<?php

declare(strict_types=1);

namespace Tests\timglabisch\PhpRtTrace;

use PHPUnit\Framework\TestCase;
use timglabisch\PhpRtTrace\RtTraceRewriter;

class PhpRtTracePrettyFilesTest extends TestCase
{
    private const REWRITE_FILES = false;

    public function dataProviderPrettyFilesDummy() {

        return [[
            __DIR__ .'/../example/method/TrTraceExampleMethodConstructor.php.pretty.php',
            __DIR__ .'/../example/method/TrTraceExampleMethodConstructor.php',
        ]];
    }

    public function dataProviderPrettyFiles() {

        foreach (glob(__DIR__ .'/../example/**/*.php') as $file) {
            if (str_contains($file, '.pretty.')) {
                continue;
            }

            yield [$file . '.pretty.php', $file . '.trace.php', $file];
        }
    }

    /** @dataProvider dataProviderPrettyFilesDummy */
    public function testPrettyFiles(string $expectedPrettyFile, string $file): void {

        // RtInternalTracer::$traceWriter = $traceWriter = new RtTraceWriterBuffer();
        $pretty = (new RtTraceRewriter())->rewriteFile($file);
        // $traces = implode("\n", $traceWriter->getBuffer());

        if (self::REWRITE_FILES) {
            file_put_contents($expectedPrettyFile, $pretty);
            // file_put_contents($expectedTraceFile, $traces);
        }

        static::assertSame(file_get_contents($expectedPrettyFile), $pretty);
        // static::assertSame(file_get_contents($expectedTraceFile), $traces);
    }
}