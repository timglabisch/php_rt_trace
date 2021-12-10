<?php

declare(strict_types=1);

namespace timglabisch\PhpRtTrace;

class RtInternalTracer
{
    public static function traceVariableAssign(mixed $value, string $name, int $startLine, string $endLine, string $file): mixed {
        $a = 0;
        return $value;
    }

    public static function traceMethodParam(mixed $value, string $className, string $methodName, string $name, int $offset, int $startLine, int $endLine, string $file): mixed {
        $a = 0;
        return $value;
    }

    public static function traceMethodReturn(mixed $value, string $className, string $methodName, int $startLine, int $endLine, string $file): mixed {
        $a = 0;
        return $value;
    }
}