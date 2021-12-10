<?php

declare(strict_types=1);

namespace timglabisch\PhpRtTrace;

use PhpParser\Error;
use PhpParser\Node;
use PhpParser\Node\Name\FullyQualified;
use PhpParser\Node\Scalar\String_;
use PhpParser\Node\Scalar\LNumber;
use PhpParser\NodeDumper;
use PhpParser\NodeTraverser;
use PhpParser\NodeVisitorAbstract;
use PhpParser\ParserFactory;
use PhpParser\Node\Stmt\Function_;
use PhpParser\PrettyPrinter;
use RtTraceExampleMethodBasic;
use timglabisch\PhpRtTrace\Visitor\RtTraceAssignVisitor;
use timglabisch\PhpRtTrace\Visitor\RtTraceMethodVisitor;


class RtTraceRewriter
{
    private const DEBUG = false;
    private const VERSION = '1';

    public function __construct(
        private array $files
    )
    {
    }

    public function run() {
        foreach ($this->files as $file) {
            $this->rewriteFile($file);
        }
    }

    public function rewriteFile(string $file) {
        $fileContent = file_get_contents($file);
        $parser = (new ParserFactory)->create(ParserFactory::PREFER_PHP7);
        try {
            $ast = $parser->parse($fileContent);
        } catch (Error $error) {
            echo "Parse error: {$error->getMessage()}\n";
            return;
        }

        $traverser = new NodeTraverser();
        $traverser->addVisitor(new RtTraceAssignVisitor($file));
        $traverser->addVisitor(new RtTraceMethodVisitor($file));

        $ast = $traverser->traverse($ast);

        $prettyPrinter = new PrettyPrinter\Standard();
        $pretty = $prettyPrinter->prettyPrintFile($ast);

        if (self::DEBUG) {
            file_put_contents($file . '.pretty.php', $pretty);
        }

        $tmpFile = './' . hash('sha512', self::VERSION . $fileContent).'.php';

        file_put_contents($tmpFile, $pretty);

        require $tmpFile;
    }

}