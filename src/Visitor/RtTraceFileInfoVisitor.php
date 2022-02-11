<?php

namespace timglabisch\PhpRtTrace\Visitor;

use PhpParser\Node;
use PhpParser\Node\Stmt\Namespace_;
use PhpParser\NodeVisitorAbstract;
use timglabisch\PhpRtTrace\Visitor\Context\RtVisitorContext;

class RtTraceFileInfoVisitor extends NodeVisitorAbstract {

    private bool $injected = false;

    public function __construct(private RtVisitorContext $context)
    {
    }

    public function leaveNode(Node $node)
    {
        if (!($node instanceof Namespace_)) {
            return;
        }

        if ($this->injected) {
            return;
        }

        $this->injected = true;

        array_unshift($node->stmts, $this->createDefineStatement());

        return $node;
    }

    private function createDefineStatement(): Node {
        return new Node\Stmt\Expression(new Node\Expr\FuncCall(
            new Node\Name('define'), [
                new Node\Arg(new Node\Scalar\String_('__' . $this->context->getFileId())),
                new Node\Arg(
                    new Node\Expr\Array_([
                        new Node\Scalar\String_($this->context->getFileId()),
                        $this->context->getFileInfoStringAsAstString()
                    ])
                )
            ]
        ));
    }

    public function afterTraverse(array $nodes) {

        if ($this->injected) {
            return;
        }

        $minPos = 0;
        foreach ($nodes as $k => $node) {
            if ($node instanceof Node\Stmt\Declare_) {
                $minPos = $k + 1;
            }
        }

        array_splice( $nodes, $minPos, 0, [$this->createDefineStatement()]);
        return $nodes;
    }

}