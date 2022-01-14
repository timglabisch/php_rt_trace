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
            __DIR__ .'/../example/property/RtTraceExamplePropertyAccessRead.php.pretty.php',
            __DIR__ .'/../example/property/RtTraceExamplePropertyAccessRead.php',
        ]];
    }

    public function dataProviderPrettyFiles() {

        foreach (glob(__DIR__ .'/../example/**/*.php') as $file) {
            if (str_contains($file, '.pretty.')) {
                continue;
            }

            yield [$file . '.pretty.php', $file];
        }
    }

    /** @dataProvider dataProviderPrettyFiles */
    public function testPrettyFiles(string $expectedPrettyFile, string $file): void {

        $pretty = (new RtTraceRewriter())->rewriteFile($file);

        if (self::REWRITE_FILES) {
            file_put_contents($expectedPrettyFile, $pretty);
        }

        $expectedPrettyFileContent = file_get_contents($expectedPrettyFile);
        static::assertSame($expectedPrettyFileContent, $pretty);
    }
}