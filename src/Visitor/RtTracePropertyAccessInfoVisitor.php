<?php

declare(strict_types=1);

namespace timglabisch\PhpRtTrace\Visitor;

use PhpParser\Node;
use PhpParser\Node\Stmt\Class_;
use PhpParser\Node\Stmt\Property;
use PhpParser\Node\Stmt\PropertyProperty;
use PhpParser\NodeVisitorAbstract;
use timglabisch\PhpRtTrace\Visitor\Context\RtVisitorContext;
use timglabisch\PhpRtTrace\Visitor\Property\RtPropertyAccessInfo;

class RtTracePropertyAccessInfoVisitor extends NodeVisitorAbstract
{
    public function __construct(
        private RtVisitorContext $context,
        private RtPropertyAccessInfo $propertyAccessInfo
    )
    {
    }

    public function enterNode(Node $node)
    {
        if ($node instanceof Class_) {
            foreach ($node->stmts as $stmt) {
                if ($stmt instanceof Property) {
                    $this->checkProperty($node, $stmt);
                }
            }
        }
    }

    private function checkProperty(Class_ $class, Property $property) {
        // $node->namespacedName->toString()

        // for now we keep the current type
        if ($property->type !== null) {
            return;
        }

        // for safety reason just private is supported now.
        if (!$property->isPrivate()) {
            return;
        }

        // for safety reason just normal classes.
        if ($class->isAbstract()) {
            return;
        }

        if (!($property->props[0] ?? null) instanceof PropertyProperty) {
            return;
        }

        $this->propertyAccessInfo->markPropertyAsInterestingToTrace($class, $property);
    }
}