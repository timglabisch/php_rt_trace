<?php

declare(strict_types=1);

namespace timglabisch\PhpRtTrace\TypeApplyer;

use PhpParser\Error;
use PhpParser\NodeAbstract;
use PhpParser\NodeTraverser;
use PhpParser\NodeVisitor\NameResolver;
use PhpParser\NodeVisitorAbstract;
use PhpParser\ParserFactory;
use PhpParser\PrettyPrinter\Standard;
use timglabisch\PhpRtTrace\LogReader\Dto\RtPropertyTypeMap;
use timglabisch\PhpRtTrace\TypeApplyer\Visitor\RtTypeApplyerPropertyVisitor;
use timglabisch\PhpRtTrace\Visitor\RtTraceAssignVisitor;
use timglabisch\PhpRtTrace\Visitor\RtTraceMethodVisitor;
use timglabisch\PhpRtTrace\Visitor\RtTracePropertyAccessAssignVisitor;
use timglabisch\PhpRtTrace\Visitor\RtTracePropertyAccessReadVisitor;

class RtTypeApplyer extends NodeVisitorAbstract
{
    /**
     * @param \PhpParser\Node\Stmt[] $ast
     */
    public function __construct(
        private array $ast,
        private string $filename,
    )
    {
    }

    public static function newFromFile(string $filename) {
        $parser = (new ParserFactory)->create(ParserFactory::PREFER_PHP7);
        try {
            $ast = $parser->parse(file_get_contents($filename));
        } catch (Error $error) {
            throw new \RuntimeException("Parse error: {$error->getMessage()}\n");
        }

        return new self($ast, $filename);
    }

    public function applyPropertyTypes(RtPropertyTypeMap $propertyTypeMap): void {
        $traverser = new NodeTraverser();
        $traverser->addVisitor(new NameResolver());
        $traverser->addVisitor(new RtTypeApplyerPropertyVisitor($propertyTypeMap));
        $this->ast = $traverser->traverse($this->ast);
    }

    public function getPretty() {
        return (new Standard())->prettyPrintFile($this->ast);
    }
}