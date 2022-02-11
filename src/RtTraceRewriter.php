<?php

declare(strict_types=1);

namespace timglabisch\PhpRtTrace;

use PhpParser\Error;
use PhpParser\NodeTraverser;
use PhpParser\NodeVisitor\NameResolver;
use PhpParser\ParserFactory;
use PhpParser\PrettyPrinter;
use timglabisch\PhpRtTrace\FileIdGenerator\RtFileIdGeneratorDefault;
use timglabisch\PhpRtTrace\FileIdGenerator\RtFileIdGeneratorInterface;
use timglabisch\PhpRtTrace\Visitor\Context\RtVisitorContext;
use timglabisch\PhpRtTrace\Visitor\Property\RtPropertyAccessInfo;
use timglabisch\PhpRtTrace\Visitor\RtTraceAssignVisitor;
use timglabisch\PhpRtTrace\Visitor\RtTraceFileInfoVisitor;
use timglabisch\PhpRtTrace\Visitor\RtTraceMethodVisitor;
use timglabisch\PhpRtTrace\Visitor\RtTracePropertyAccessAssignVisitor;
use timglabisch\PhpRtTrace\Visitor\RtTracePropertyAccessInfoVisitor;
use timglabisch\PhpRtTrace\Visitor\RtTracePropertyAccessReadVisitor;
use timglabisch\PhpRtTrace\Visitor\RtTraceUnsupportedVisitor;


class RtTraceRewriter
{
    private RtFileIdGeneratorInterface $fileIdGenerator;

    public function __construct(
        ?RtFileIdGeneratorInterface $fileIdGenerator = null
    )
    {
        $this->fileIdGenerator = $fileIdGenerator ?? new RtFileIdGeneratorDefault();
    }

    public function compileAndInclude(array $files): void
    {
        foreach ($files as $file) {
            $pretty = $this->rewriteFile($file);
            $this->evalInclude($pretty);
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

        $context = new RtVisitorContext(
            fileId: $this->fileIdGenerator->generateFileId($filename),
            filename: $filename,
        );

        $traverser = new NodeTraverser();
        $traverser->addVisitor(new RtTraceUnsupportedVisitor($context));
        $traverser->addVisitor(new RtTracePropertyAccessInfoVisitor($context, $propertyAccessInfo = new RtPropertyAccessInfo()));
        $traverser->addVisitor(new NameResolver(null, ['preserveOriginalNames' => true, 'replaceNodes' => false]));
        $traverser->addVisitor(new RtTraceFileInfoVisitor($context));
        // for now, tracing all assigns is too much
        // $traverser->addVisitor(new RtTraceAssignVisitor($context));
        $traverser->addVisitor(new RtTracePropertyAccessAssignVisitor($context, $propertyAccessInfo));
        $traverser->addVisitor(new RtTracePropertyAccessReadVisitor($context, $propertyAccessInfo));
        //$traverser->addVisitor(new RtTraceMethodVisitor($context));

        $ast = $traverser->traverse($ast);

        if ($context->getFileIsNotSupportedReason()) {
            echo 'could not rewrite file ' . $filename . ' reason '. $context->getFileIsNotSupportedReason() . "\n";
            return $fileContent;
        }

        $prettyPrinter = new PrettyPrinter\Standard();
        $pretty = $prettyPrinter->prettyPrintFile($ast);

        return $pretty;
    }

}