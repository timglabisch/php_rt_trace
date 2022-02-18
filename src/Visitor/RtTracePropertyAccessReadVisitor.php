<?php

declare(strict_types=1);

namespace timglabisch\PhpRtTrace\Visitor;

use PhpParser\Node;
use PhpParser\Node\Expr\AssignOp;
use PhpParser\Node\Expr\PropertyFetch;
use PhpParser\Node\Expr\Variable;
use PhpParser\Node\Name\FullyQualified;
use PhpParser\Node\Scalar\LNumber;
use PhpParser\Node\Scalar\String_;
use PhpParser\NodeTraverser;
use PhpParser\NodeVisitorAbstract;
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
            if ($v instanceof Node\Expr\AssignOp) {
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

        $isIsset = fn (Node $node) => $node instanceof Node\Expr\Isset_;

        if ($isIsset($node)) {
            return $this->leaveNodeIsset($node);
        }

        if (!$this->nodeStack->isEmpty() && ($parent = $this->nodeStack->top()) && $isIsset($parent)) {
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

        if (
            !$this->nodeStack->isEmpty()
            && ($parent = $this->nodeStack->top())
            && $parent instanceof Node\Arg
        ) {
            return;
        }

        return $this->traceExpression($propertyFetch, $node);
    }

    private function buildRecusiveBooleanAnd(array $expression) {
        if (count($expression) === 1) {
            return $expression[0];
        }

        $item = array_shift($expression);

        return new Node\Expr\BinaryOp\BooleanAnd($item, $this->buildRecusiveBooleanAnd($expression));
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

    public function leaveNodeIsset(Node\Expr\Isset_ $call) {
        $class = $this->classStack->isEmpty() ? null : $this->classStack->top();

        if (!$class) {
            return $call;
        }

        $calls = [];
        foreach ($call->vars as $expr) {
            if (!($expr instanceof PropertyFetch)) {
                $calls[] = new Node\Expr\Isset_([$expr]);
                continue;
            }

            $var = $expr->var;
            if (!($var instanceof Variable)) {
                $calls[] = new Node\Expr\Isset_([$expr]);
                continue;
            }

            // property must be in $this scope.
            if ($var->name !== 'this') {
                $calls[] = new Node\Expr\Isset_([$expr]);
                continue;
            }

            if (!$this->propertyAccessInfo->isPropertyFetchInterestingToTrace($class, $expr)) {
                $calls[] = new Node\Expr\Isset_([$expr]);
                continue;
            }

            // isset with expressions like $this->{'x'} are not supported yet.
            // they may contain variables that are not in the function scope we generate ...
            if (!($expr->name instanceof Node\Identifier)) {
                $calls[] = new Node\Expr\Isset_([$expr]);
                continue;
            }

            $calls[] = new Node\Expr\FuncCall(
                new Node\Expr\Closure([
                    'stmts' => [
                        new Node\Stmt\If_(
                            new Node\Expr\BooleanNot(new Node\Expr\Isset_([$expr])),
                            [
                                'stmts' => [
                                    new Node\Stmt\Return_(new Node\Expr\ConstFetch(new Node\Name('false')))
                                ]
                            ]
                        ),
                        new Node\Stmt\Expression($this->traceExpression($expr, $expr)),
                        new Node\Stmt\Return_(new Node\Expr\ConstFetch(new Node\Name('true')))
                    ]
                ])
            );
        }

        return $this->buildRecusiveBooleanAnd($calls);

    }

    public function leaveNodePrePostAssign(Node\Expr\PostInc|Node\Expr\PostDec|Node\Expr\PreInc|Node\Expr\PreDec|AssignOp $node) {

        // do not trace bitwise operations
        if (
            $node instanceof AssignOp\BitwiseAnd
            || $node instanceof AssignOp\BitwiseOr
            || $node instanceof AssignOp\BitwiseXor
        ) {
            return;
        }

        if (!($node->var instanceof PropertyFetch)) {
            return;
        }

        // both are invalid php (if b needs a reference)
        // b($a->a += 1);
        // b($a->a++);
        if (!$this->classStack->top() || !$this->propertyAccessInfo->isPropertyFetchInterestingToTrace($this->classStack->top(), $node->var)) {
            return;
        }

        return $this->traceExpression($node->var, $node);
    }

    public function leaveNodeFuncCall(Node\Expr\FuncCall $call) {

        $class = !$this->classStack->isEmpty() ? $this->classStack->top() : null;
        if (!$class instanceof Node\Stmt\Class_) {
            return;
        }

        $propertyFetches = [];
        foreach ($call->args as $arg) {
            if (!($arg instanceof Node\Arg)) {
                continue;
            }

            if (
                $arg->value instanceof Node\Expr\PropertyFetch
                && $this->propertyAccessInfo->isPropertyFetchInterestingToTrace($class, $arg->value)
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