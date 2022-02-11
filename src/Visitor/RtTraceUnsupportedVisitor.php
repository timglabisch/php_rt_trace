<?php

declare(strict_types=1);

namespace timglabisch\PhpRtTrace\Visitor;

use PhpParser\Node;
use PhpParser\NodeVisitorAbstract;
use timglabisch\PhpRtTrace\Visitor\Context\RtVisitorContext;

class RtTraceUnsupportedVisitor extends NodeVisitorAbstract
{
    public function __construct(private RtVisitorContext $context)
    {
    }

    public function enterNode(Node $node)
    {
        if ($node instanceof Node\Stmt\ClassMethod) {
            if (in_array($node->name->name, ['__get', '__set', '__isset', '__unset'])) {
                $this->context->setFileIsNotSupportedReason("Classes with _'__get', '__set', '__isset', '__unset' are not supported yet");
            }
        }

        if ($node instanceof Node\Stmt\Class_) {
            if (!$node->name) {
                $this->context->setFileIsNotSupportedReason("files with anon classes are not yet supported.");
            }
        }
    }


}