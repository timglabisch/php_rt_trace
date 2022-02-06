<?php

namespace timglabisch\PhpRtTrace\Visitor;

use PhpParser\Node;
use PhpParser\Node\Stmt\Namespace_;
use PhpParser\NodeVisitorAbstract;

class RtTraceFileInfoVisitor extends NodeVisitorAbstract {

    private bool $injected = false;

    public function __construct(private string $file)
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
                new Node\Arg(new Node\Scalar\String_('__RT' .str_replace('.', '', uniqid('', true)))),
                new Node\Arg(
                    new Node\Expr\Array_([
                        new Node\Scalar\String_('id'),
                        new Node\Scalar\String_('file_info')
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
                $minPos = $k;
            }
        }

        return array_splice( $nodes, $minPos, 0, $this->createDefineStatement());
    }

}