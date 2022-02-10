<?php

declare(strict_types=1);

namespace timglabisch\PhpRtTrace\Visitor;

use PhpParser\Node;
use PhpParser\Node\Name\FullyQualified;
use PhpParser\Node\Scalar\LNumber;
use PhpParser\Node\Scalar\String_;
use PhpParser\Node\Stmt\ClassMethod;
use PhpParser\NodeVisitorAbstract;
use timglabisch\PhpRtTrace\RtInternalTracer;
use timglabisch\PhpRtTrace\Visitor\Context\RtVisitorContext;

class RtTracePropertyAccessAssignVisitor extends NodeVisitorAbstract
{
    private \SplStack $classStack;

    public function __construct(private RtVisitorContext $context)
    {
        $this->classStack = new \SplStack();
    }

    public function enterNode(Node $node)
    {
        if ($node instanceof Node\Stmt\Class_) {
            $this->classStack->push($node);
            return;
        }
    }

    public function leaveNode(Node $node)
    {
        if ($node instanceof Node\Stmt\Class_) {
            $this->classStack->pop();
            return;
        }

        if (!$node instanceof Node\Expr\Assign) {
            return;
        }

        $propertyFetch = $node->var;
        if (!($propertyFetch instanceof Node\Expr\PropertyFetch)) {
            return;
        }

        if (!$propertyFetch->var instanceof Node\Expr\Variable) {
            return;
        }

        // we just care about properties that are accessed like "this->..."!
        if ($propertyFetch->var->name !== "this") {
            return;
        }

        if (!$propertyFetch->name instanceof Node\Identifier) {
            return;
        }

        if ($this->classStack->isEmpty()) {
            return;
        }

        $class = $this->classStack->top();
        if (!$class instanceof Node\Stmt\Class_) {
            return;
        }

        $node->expr = new Node\Expr\StaticCall(
            class: new FullyQualified(RtInternalTracer::class),
            name: new Node\Identifier('tracePropertyAssign'),
            args: [
                $node->expr,
                new String_($class->namespacedName?->toString() ?? 'unknown'),
                new String_($propertyFetch->name->name),
                new LNumber($propertyFetch->getStartLine()),
                new LNumber($propertyFetch->getEndLine()),
                $this->context->getFileInfoStringAsAstConstFetch(),
            ]
        );

    }
}