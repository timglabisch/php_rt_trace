<?php

declare(strict_types=1);

namespace timglabisch\PhpRtTrace\Visitor\Helper;

use PhpParser\Node;
use PhpParser\NodeAbstract;
use PhpParser\NodeVisitorAbstract;

class RtTraceVisitorIsChildOfVisitor extends NodeVisitorAbstract
{
    private ?Node $found = null;

    public function __construct(
        private mixed $findCallable
    ) {
    }

    public function enterNode(Node $node)
    {
        $callable = $this->findCallable;

        if ($this->found) {
            return;
        }

        if ($callable($node)) {
            $this->found = $node;
        }
    }

    public function getFoundNode(): ?Node {
        return $this->found;
    }

}