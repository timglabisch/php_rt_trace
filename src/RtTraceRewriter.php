<?php

declare(strict_types=1);

namespace timglabisch\PhpRtTrace;

use PhpParser\Error;
use PhpParser\NodeTraverser;
use PhpParser\ParserFactory;
use PhpParser\PrettyPrinter;
use timglabisch\PhpRtTrace\Visitor\RtTraceAssignVisitor;
use timglabisch\PhpRtTrace\Visitor\RtTraceMethodVisitor;


class RtTraceRewriter
{
    private const DEBUG = false;
    private const VERSION = '1';

    public function compileAndInclude(array $files): void
    {
        foreach ($files as $file) {
            $pretty = $this->rewriteFile($file);
            $this->writePrettyFileIfDebug($file, $pretty);
            $this->evalInclude($pretty);
        }
    }

    public function writePrettyFileIfDebug(string $filename, string $pretty)
    {
        if (self::DEBUG) {
            file_put_contents($filename . '.pretty.php', $pretty);
        }
    }

    public function evalInclude(string $pretty)
    {
        eval ($pretty);
    }

    public function rewriteFile(string $filename): string
    {
        return $this->rewriteFileContent($filename, file_get_contents($filename));
    }

    public function rewriteFileContent(string $filename, string $fileContent): string
    {
        $parser = (new ParserFactory)->create(ParserFactory::PREFER_PHP7);
        try {
            $ast = $parser->parse($fileContent);
        } catch (Error $error) {
            echo "Parse error: {$error->getMessage()}\n";
        }

        $traverser = new NodeTraverser();
        $traverser->addVisitor(new RtTraceAssignVisitor($filename));
        $traverser->addVisitor(new RtTraceMethodVisitor($filename));

        $ast = $traverser->traverse($ast);

        $prettyPrinter = new PrettyPrinter\Standard();
        $pretty = $prettyPrinter->prettyPrintFile($ast);

        return $pretty;
    }

}