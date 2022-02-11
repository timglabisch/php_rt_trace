<?php

declare(strict_types=1);

namespace timglabisch\PhpRtTrace\Visitor\Property;

use PhpParser\Node\Expr\PropertyFetch;
use PhpParser\Node\Identifier;
use PhpParser\Node\Name;
use PhpParser\Node\Stmt\Class_;
use PhpParser\Node\Stmt\Property;
use PhpParser\Node\Stmt\PropertyProperty;

class RtPropertyAccessInfo
{
    private array $data = [];

    public function markPropertyAsInterestingToTrace(Class_ $class, Property $property): void {
        if (!($property->props[0] ?? null) instanceof PropertyProperty) {
            return;
        }

        if ($class->name === null) {
            return;
        }

        $this->data[$class->name->name] ??= [];
        $this->data[$class->name->name][$property->props[0]->name->name] = true;
    }

    public function isPropertyInterestingToTrace(Class_ $class, Property $property): bool {
        if (!($property->props[0] ?? null) instanceof PropertyProperty) {
            return false;
        }

        if ($class->name === null) {
            return false;
        }

        return isset($this->data[$class->name->name][$property->props[0]->name->name]);
    }

    public function isPropertyFetchInterestingToTrace(Class_ $class, PropertyFetch $property): bool {

        if ($property->name instanceof Identifier) {
            return isset($this->data[$class->name->name][$property->name->name]);
        }

        // we've a dynamic property, we trace it because we dont know if it could be interesting.
        return true;
    }

}