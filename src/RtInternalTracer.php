<?php

declare(strict_types=1);

namespace timglabisch\PhpRtTrace;

use timglabisch\PhpRtTrace\TraceWriter\RtTraceWriterInterface;

class RtInternalTracer
{
    public static ?RtTraceWriterInterface $traceWriter = null;

    private static function encodeAndSaveBlock(array $arr): void {
        self::$traceWriter?->write($arr);
    }

    public static function traceVariableAssign(mixed $value, string $name, int $startLine, int $endLine, string $file): mixed {
        static::encodeAndSaveBlock([
            'opcode' => 'VariableAssign',
            'type' => [get_debug_type($value) => 1],
            'name' => $name,
            'line' => $startLine.':'.$endLine,
            'file' => $file,
        ]);

        return $value;
    }

    public static function traceMethodParam(mixed $value, string $className, string $methodName, string $name, int $offset, int $startLine, int $endLine, string $file): mixed {
        static::encodeAndSaveBlock([
            'opcode' => 'MethodParam',
            'type' => get_debug_type($value),
            'class' => $className,
            'method' => $methodName,
            'name' => $name,
            'line' => $startLine.':'.$endLine,
            'file' => $file,
        ]);

        return $value;
    }

    public static function traceMethodReturn(mixed $value, string $className, string $methodName, int $startLine, int $endLine, string $file): mixed {
        static::encodeAndSaveBlock([
            'opcode' => 'MethodReturn',
            'type' => get_debug_type($value),
            'class' => $className,
            'method' => $methodName,
            'line' => $startLine.':'.$endLine,
            'file' => $file,
        ]);

        return $value;
    }

    public static function tracePropertyAssign(mixed $value, string $className, string $propertyName, int $startLine, int $endLine, string $file): mixed {
        static::encodeAndSaveBlock([
            'opcode' => 'PropertyAssign',
            'type' => get_debug_type($value),
            'class' => $className,
            'propertyName' => $propertyName,
            'line' => $startLine.':'.$endLine,
            'file' => $file,
        ]);

        return $value;
    }

    public static function tracePropertyFetch(mixed $value, string $className, string $propertyName, int $startLine, int $endLine, string $file): mixed {
        static::encodeAndSaveBlock([
            'opcode' => 'PropertyFetch',
            'type' => get_debug_type($value),
            'class' => $className,
            'propertyName' => $propertyName,
            'line' => $startLine.':'.$endLine,
            'file' => $file,
        ]);

        return $value;
    }
}