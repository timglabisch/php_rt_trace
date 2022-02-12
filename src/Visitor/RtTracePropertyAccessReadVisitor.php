<?php

declare(strict_types=1);

namespace timglabisch\PhpRtTrace\Visitor;

use PhpParser\Node;
use PhpParser\Node\Expr\PropertyFetch;
use PhpParser\Node\Name\FullyQualified;
use PhpParser\Node\Scalar\LNumber;
use PhpParser\Node\Scalar\String_;
use PhpParser\NodeTraverser;
use PhpParser\NodeVisitorAbstract;
use SebastianBergmann\CodeCoverage\Node\AbstractNode;
use timglabisch\PhpRtTrace\RtInternalTracer;
use timglabisch\PhpRtTrace\Visitor\Context\RtVisitorContext;
use timglabisch\PhpRtTrace\Visitor\Helper\RtTraceVisitorIsChildOfVisitor;
use timglabisch\PhpRtTrace\Visitor\Property\RtPropertyAccessInfo;

class RtTracePropertyAccessReadVisitor extends NodeVisitorAbstract
{
    private \SplStack $classStack;

    public function __construct(
        private RtVisitorContext $context,
        private RtPropertyAccessInfo $propertyAccessInfo
    )
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
            $childOfVisitor = (new RtTraceVisitorIsChildOfVisitor(fn(Node $v) => $v === $node));
            $traverser->addVisitor($childOfVisitor);
            $traverser->traverse([$assign->var]);

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



        $isPrePostAssign = fn ($node) =>
            $node instanceof Node\Expr\PostInc
            || $node instanceof Node\Expr\PreInc
            || $node instanceof Node\Expr\PostDec
            || $node instanceof Node\Expr\PreDec
            || $node instanceof Node\Expr\AssignOp
        ;

        if ($isPrePostAssign($node)) {
            return $this->leaveNodePrePostAssign($node);
        }

        if ($this->findNodeByNodeStack(fn (Node $v) => $isPrePostAssign($v))) {
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

        if (!$this->propertyAccessInfo->isPropertyFetchInterestingToTrace($class, $propertyFetch)) {
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

        return $this->traceExpression($propertyFetch, $node);
    }

    private function traceExpression(PropertyFetch $propertyFetch, Node\Expr $expression) {
        return new Node\Expr\StaticCall(
            class: new FullyQualified(RtInternalTracer::class),
            name: new Node\Identifier('tracePropertyFetch'),
            args: [
                $expression,
                new Node\Expr\ConstFetch(new Node\Name('__CLASS__')),
                new String_($propertyFetch->name->name),
                new LNumber($propertyFetch->getStartLine()),
                new LNumber($propertyFetch->getEndLine()),
                $this->context->getFileInfoStringAsAstConstFetch(),
            ]
        );
    }

    public function leaveNodePrePostAssign(Node\Expr\PostInc|Node\Expr\PostDec|Node\Expr\PreInc|Node\Expr\PreDec|Node\Expr\AssignOp $node) {

        // both are invalid php (if b needs a reference)
        // b($a->a += 1);
        // b($a->a++);
        if (!($node->var instanceof PropertyFetch)) {
            return;
        }

        if (!$this->classStack->top() || !$this->propertyAccessInfo->isPropertyFetchInterestingToTrace($this->classStack->top(), $node->var)) {
            return;
        }

        return $this->traceExpression($node->var, $node);
    }

    public function leaveNodeFuncCall(Node\Expr\FuncCall $call) {

        $propertyFetches = [];
        foreach ($call->args as $arg) {
            if (!($arg instanceof Node\Arg)) {
                continue;
            }

            if (
                $arg->value instanceof Node\Expr\PropertyFetch
                && $this->classStack->top()
                && $this->propertyAccessInfo->isPropertyFetchInterestingToTrace($this->classStack->top(), $arg->value)
            ) {
                $propertyFetches[] = $arg->value;
            }
        }

        if (!$propertyFetches) {
            return;
        }

        // needed?
        if ($this->nodeIsOnLeftSideOfAssignments($call, $this->getAssignFromNodeStack())) {
            return; // @see RtTracePropertyAccessAssignVisitor
        }

        $class = $this->classStack->top();
        if (!$class instanceof Node\Stmt\Class_) {
            return;
        }

        return new Node\Expr\ArrayDimFetch(
            new Node\Expr\FuncCall(
                new Node\Expr\ArrowFunction([
                    'expr' => new Node\Expr\Array_(
                        array_merge(
                            [$call],
                            array_map(function(Node\Expr\PropertyFetch $propertyFetch) use ($class) {
                                return new Node\Expr\StaticCall(
                                    class: new FullyQualified(RtInternalTracer::class),
                                    name: new Node\Identifier('tracePropertyFetch'),
                                    args: [
                                        $propertyFetch,
                                        new Node\Expr\ConstFetch(new Node\Name('__CLASS__')),
                                        new String_($propertyFetch->name->name),
                                        new LNumber($propertyFetch->getStartLine()),
                                        new LNumber($propertyFetch->getEndLine()),
                                        $this->context->getFileInfoStringAsAstConstFetch(),
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