<?php

declare(strict_types=1);

namespace Tests\timglabisch\PhpRtTrace;

use PHPUnit\Framework\TestCase;
use timglabisch\PhpRtTrace\RtTraceRewriter;

class PhpRtTracePrettyFilesTest extends TestCase
{
    public function dataProviderPrettyFiles(): \Generator {
        foreach (glob(__DIR__ .'/../example/**/*.pretty.php') as $file) {
            yield [$file, str_replace('.pretty.php', '', $file)];
        }
    }

    /** @dataProvider dataProviderPrettyFiles */
    public function testPrettyFiles(string $expectedPrettyFile, string $file): void {

        $pretty = (new RtTraceRewriter())->rewriteFile($file);

        static::assertSame($expectedPrettyFile, $pretty);
    }
}