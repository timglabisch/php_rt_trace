<?php

declare(strict_types=1);

namespace timglabisch\PhpRtTrace\TypeApplyer\Visitor;

use PhpParser\Node;
use PhpParser\Node\Stmt\ClassMethod;
use PhpParser\NodeVisitorAbstract;
use timglabisch\PhpRtTrace\LogReader\Dto\RtPropertyTypeMap;

class RtTypeApplyerPropertyVisitor extends NodeVisitorAbstract
{
    public function __construct(
        private RtPropertyTypeMap $propertyTypeMap
    )
    {
    }

    public function leaveNode(Node $node)
    {
        $a = 0;
    }
}