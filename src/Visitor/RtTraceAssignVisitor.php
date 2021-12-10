<?php

declare(strict_types=1);

namespace timglabisch\PhpRtTrace\Visitor;

use PhpParser\Node;
use PhpParser\Node\Name\FullyQualified;
use PhpParser\Node\Scalar\LNumber;
use PhpParser\Node\Scalar\String_;
use PhpParser\NodeVisitorAbstract;
use timglabisch\PhpRtTrace\RtInternalTracer;

class RtTraceAssignVisitor extends NodeVisitorAbstract {

    public function __construct(private string $file)
    {
    }

    public function leaveNode(Node $node) {

        if ($node instanceof Node\Expr\Assign) {
            // classic $var = EXPR;
            $var = $node->var;
            if ($var instanceof Node\Expr\Variable) {
                $newNode = new Node\Expr\StaticCall(
                    class: new FullyQualified(RtInternalTracer::class),
                    name: new Node\Identifier('traceVariableAssign'),
                    args: [
                        $node->expr,
                        new String_($var->name),
                        new LNumber($var->getStartLine()),
                        new LNumber($var->getEndLine()),
                        new String_($this->file),
                    ]
                );

                $node->expr = $newNode;
            }
        }
    }
}