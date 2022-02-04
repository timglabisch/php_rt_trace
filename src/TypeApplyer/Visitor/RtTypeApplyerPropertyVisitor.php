<?php

declare(strict_types=1);

namespace timglabisch\PhpRtTrace\TypeApplyer\Visitor;

use PhpParser\Node;
use PhpParser\Node\Identifier;
use PhpParser\Node\Stmt\Class_;
use PhpParser\Node\Stmt\ClassMethod;
use PhpParser\Node\Stmt\Property;
use PhpParser\Node\UnionType;
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
        if ($node instanceof Class_) {
            foreach ($node->stmts as $stmt) {
                if ($stmt instanceof Property) {
                    $this->rewriteProperty($node, $stmt);
                }
            }
            $a = 0;
        }
    }

    private function rewriteProperty(Class_ $class, Property $property) {
        // $node->namespacedName->toString()

        // for now we keep the current type
        if ($property->type !== null) {
            return;
        }

        $typeInfo = $this->propertyTypeMap->getTypesByAst($class, $property);

        $identifiers = array_map(fn(string $type) => new Identifier($type), $typeInfo);

        // todo, originaltyp rausfinden welches mit "=" gesetzt wurde.

        if (count($identifiers) === 1) {
            $property->type = $identifiers[0];
            return;
        }

        $property->type = new UnionType($identifiers);
    }
}