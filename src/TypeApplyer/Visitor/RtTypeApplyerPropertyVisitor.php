<?php

declare(strict_types=1);

namespace timglabisch\PhpRtTrace\TypeApplyer\Visitor;

use PhpParser\Node;
use PhpParser\Node\Expr\Array_;
use PhpParser\Node\Expr\ClassConstFetch;
use PhpParser\Node\Identifier;
use PhpParser\Node\Stmt\Class_;
use PhpParser\Node\Stmt\ClassMethod;
use PhpParser\Node\Stmt\Property;
use PhpParser\Node\Stmt\PropertyProperty;
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

        $propertyProperty = $property->props[0];

        $typeInfo = $this->propertyTypeMap->getTypesByAst($class, $property);

        if ($typeInfo === []) {
            return;
        }

        $addType = function(string $type) use (&$typeInfo) {
            if (in_array($type, $typeInfo)) {
                return;
            }

            $typeInfo[] = $type;
        };

        if ($propertyProperty->default !== null) {
            if ($propertyProperty->default instanceof Node\Scalar\LNumber) {
                $addType('int');
            } elseif ($propertyProperty->default instanceof Node\Scalar\DNumber) {
                $addType('float');
            } elseif ($propertyProperty->default instanceof Node\Scalar\String_) {
                $addType('string');
            } elseif ($propertyProperty->default instanceof Array_) {
                $addType('array');
            } elseif ($propertyProperty->default instanceof ClassConstFetch) {
                $addType('string');
            } elseif ($propertyProperty->default instanceof Node\Expr\ConstFetch) {
                if ($propertyProperty->default->name->parts == ['null']) {
                    $addType('null');
                } else {
                    throw new \LogicException('not fully sure what to do.');
                }
            } else {
                throw new \LogicException(
                    'unsupported type' . get_class($propertyProperty->default)
                );
            }
        }

        // just null is not a valid type hint.
        if ($typeInfo === ['null']) {
            return;
        }

        // we prefer a nullable type instead of a union type with null.
        if (count($typeInfo) === 2 && in_array('null', $typeInfo, true)) {
            $property->type = new Node\NullableType(
                $typeInfo[0] === 'null' ? $typeInfo[1] : $typeInfo[0]
            );
            return;
        }

        usort($typeInfo, fn(string $a, string $b) => strnatcmp($a, $b));

        $identifiers = array_map(fn(string $type) => new Identifier($type), $typeInfo);

        // todo, originaltyp rausfinden welches mit "=" gesetzt wurde.

        if (count($identifiers) === 1) {
            $property->type = $identifiers[0];
            return;
        }

        $property->type = new UnionType($identifiers);
    }
}