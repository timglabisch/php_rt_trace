<?php

declare(strict_types=1);

namespace timglabisch\PhpRtTrace\LogReader\Dto;

use PhpParser\Node\Stmt\Class_;
use PhpParser\Node\Stmt\Property;

class RtPropertyTypeMap
{
    public function __construct(
        private array $data
    )
    {
    }

    /** @return string[] */
    public function getTypes(string $classname, string $propertyName): array {
        $buf = [];
        foreach ($this->data[$classname][$propertyName]['types'] ?? [] as $type => $_) {
            $buf[] = $type;
        }

        usort($buf, fn(string $a, string $b) => strnatcmp($a, $b));

        return $buf;
    }

    public function getTypesByAst(Class_ $class, Property $property) {
        if (!array_key_exists(0, $property->props)) {
            return;
        }

        $propertyName = $property->props[0]->name->name;

        return $this->getTypes($class->namespacedName->toString(), $propertyName);
    }
}