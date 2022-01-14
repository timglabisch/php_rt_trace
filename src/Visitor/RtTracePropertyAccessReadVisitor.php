<?php

declare(strict_types=1);

namespace timglabisch\PhpRtTrace\Visitor;

use PhpParser\Node;
use PhpParser\Node\Name\FullyQualified;
use PhpParser\Node\Scalar\LNumber;
use PhpParser\Node\Scalar\String_;
use PhpParser\NodeTraverser;
use PhpParser\NodeVisitorAbstract;
use SebastianBergmann\CodeCoverage\Node\AbstractNode;
use timglabisch\PhpRtTrace\RtInternalTracer;
use timglabisch\PhpRtTrace\Visitor\Helper\RtTraceVisitorIsChildOfVisitor;

class RtTracePropertyAccessReadVisitor extends NodeVisitorAbstract
{
    private \SplStack $classStack;

    public function __construct(private string $file)
    {
        $this->classStack = new \SplStack();
        $this->nodeStack = new \SplStack();
    }

    public function enterNode(Node $node)
    {
        $this->nodeStack->push($node);
        if ($node instanceof Node\Stmt\Class_) {
            $this->classStack->push($node);
            return;
        }
    }

    /** @return Node\Expr\Assign[] */
    public function getAssignFromNodeStack(): array {
        $assigns = [];
        foreach ($this->nodeStack as $v) {
            if ($v instanceof Node\Expr\Assign) {
                $assigns[] = $v;
            }
        }

        return $assigns;
    }

    /** @param $assigns Node\Expr\Assign[] */
    public function nodeIsOnLeftSideOfAssignments(Node $node, array $assigns): bool {
        foreach ($assigns as $assign) {
            $traverser = (new NodeTraverser());
            $childOfVisitor = (new RtTraceVisitorIsChildOfVisitor($assign->var));
            $traverser->addVisitor($childOfVisitor);
            $traverser->traverse([$node]);

            if ($childOfVisitor->hasFound()) {
                return true;
            }
        }

        return false;
    }

    public function leaveNode(Node $node)
    {
        $this->nodeStack->pop();
        if ($node instanceof Node\Stmt\Class_) {
            $this->classStack->pop();
            return;
        }

        if (!$node instanceof  Node\Expr\PropertyFetch) {
            return;
        }

        $propertyFetch = $node;
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

        $class = $this->classStack->top();
        if (!$class instanceof Node\Stmt\Class_) {
            return;
        }

        // we need to know if we're on the left side of an assignment or not.
        // for example
        // $this->foo = XXX;
        // is different to
        // $xxx = $this->foo
        // because we could not wrap a function in the left side of the assignment like
        // $FUNC($xxx) = $this->foo

        if ($this->nodeIsOnLeftSideOfAssignments($node, $this->getAssignFromNodeStack())) {
            return; // @see RtTracePropertyAccessAssignVisitor
        }

        return new Node\Expr\StaticCall(
            class: new FullyQualified(RtInternalTracer::class),
            name: new Node\Identifier('tracePropertyFetch'),
            args: [
                $node,
                new String_($class->name?->name ?? 'unknown'),
                new String_($propertyFetch->name->name),
                new LNumber($propertyFetch->getStartLine()),
                new LNumber($propertyFetch->getEndLine()),
                new String_($this->file),
            ]
        );

    }

}