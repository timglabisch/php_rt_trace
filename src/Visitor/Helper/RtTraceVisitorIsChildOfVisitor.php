<?php

declare(strict_types=1);

namespace timglabisch\PhpRtTrace\Visitor\Helper;

use PhpParser\Node;
use PhpParser\NodeAbstract;
use PhpParser\NodeVisitorAbstract;

class RtTraceVisitorIsChildOfVisitor extends NodeVisitorAbstract
{
    private bool $found = false;

    public function __construct(
        private NodeAbstract $nodeToFind
    ) {
    }

    public function enterNode(Node $node)
    {
        if ($this->found) {
            return;
        }

        if ($this->nodeToFind === $node) {
            $this->found = true;
        }
    }

    public function hasFound(): bool {
        return $this->found;
    }

}