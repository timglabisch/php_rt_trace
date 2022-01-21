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
            $childOfVisitor = (new RtTraceVisitorIsChildOfVisitor(fn(Node $v) => $v === $assign->var));
            $traverser->addVisitor($childOfVisitor);
            $traverser->traverse([$node]);

            if ($childOfVisitor->getFoundNode()) {
                return true;
            }
        }

        return false;
    }

    public function findNodeByNodeStack(callable $callable): ?Node {
        foreach ($this->nodeStack as $item) {
            if ($callable($item)) {
                return $item;
            }
        }

        return null;
    }

    public function leaveNode(Node $node)
    {
        $this->nodeStack->pop();
        if ($node instanceof Node\Stmt\Class_) {
            $this->classStack->pop();
            return;
        }

        if ($node instanceof Node\Expr\FuncCall) {
            return $this->leaveNodeFuncCall($node);
        }

        if (!$node instanceof Node\Expr\PropertyFetch) {
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

        if ($this->classStack->isEmpty()) {
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

        if ($this->findNodeByNodeStack(fn (Node $v) => $v instanceof Node\Arg)) {
            // when our current node is part of a param (function call) it becomes a bit trickier
            // because the function call might want to have &$this->XXX instead of $this->XXX
            return;
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

    public function leaveNodeFuncCall(Node\Expr\FuncCall $call) {

        $propertyFetches = [];
        foreach ($call->args as $arg) {
            if (!($arg instanceof Node\Arg)) {
                continue;
            }

            if ($arg->value instanceof Node\Expr\PropertyFetch) {
                $propertyFetches[] = $arg->value;
            }
        }

        if (!$propertyFetches) {
            return;
        }

        return new Node\Expr\ArrayDimFetch(
            new Node\Expr\FuncCall(
                new Node\Expr\ArrowFunction([
                    'expr' => new Node\Expr\Array_(
                        array_merge(
                            [$call],
                            array_map(function(Node\Expr\PropertyFetch $propertyFetch) {
                                return new Node\Expr\StaticCall(
                                    class: new FullyQualified(RtInternalTracer::class),
                                    name: new Node\Identifier('tracePropertyFetch'),
                                    args: [
                                        $propertyFetch,
                                        new String_($class->name?->name ?? 'unknown'),
                                        new String_($propertyFetch->name->name),
                                        new LNumber($propertyFetch->getStartLine()),
                                        new LNumber($propertyFetch->getEndLine()),
                                        new String_($this->file),
                                    ]
                                );
                            }, $propertyFetches)
                        )
                    )
                ])
            ),
            new LNumber(0)
        );
    }

}