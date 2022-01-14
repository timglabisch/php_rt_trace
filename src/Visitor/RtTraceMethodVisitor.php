<?php

declare(strict_types=1);

namespace timglabisch\PhpRtTrace\Visitor;

use PhpParser\Comment\Doc;
use PhpParser\Node;
use PhpParser\Node\Name\FullyQualified;
use PhpParser\Node\Scalar\LNumber;
use PhpParser\Node\Scalar\String_;
use PhpParser\Node\Stmt\ClassMethod;
use PhpParser\NodeVisitorAbstract;
use timglabisch\PhpRtTrace\RtInternalTracer;

class RtTraceMethodVisitor extends NodeVisitorAbstract
{

    public function __construct(private string $file)
    {
    }

    public function leaveNode(Node $node)
    {

        if ($node instanceof Node\Stmt\Class_) {

            if ($node->isAbstract()) {
                return;
            }

            foreach ($node->stmts as $stmt) {
                if ($stmt instanceof ClassMethod) {
                    $this->leaveClassMethod($node, $stmt);
                }
            }
        }
    }

    private function leaveClassMethod(Node\Stmt\Class_ $class, Node\Stmt\ClassMethod $classMethod)
    {
        if ($classMethod->name->name === "__construct") {
            // constructor is not yet supported, a bit more complex because we cant simply copy the methode.
            // it may looks like __construct(private ...) which is just supported in constructors.
            return;
        }

        if ($classMethod->isPrivate()) {
            return;
        }

        if ($classMethod->isStatic()) {
            // static methods are special
            return;
        }

        $clone = clone $classMethod;
        $newFunctioName = '__rt_trace__' . $clone->name->name;

        $clone->name = new Node\Identifier($newFunctioName);
        $clone->setDocComment(new Doc(''));
        $clone->attrGroups = [];

        // $clone-> todo, make private

        $class->stmts[] = $clone;


        $returnsVoid = $classMethod->getReturnType() instanceof Node\Identifier && $classMethod->getReturnType()->name === 'void';

        $params = [];

        foreach (array_values($clone->params) as $i => $origParam) {

            if (!$origParam instanceof Node\Param) {
                throw new \LogicException('param has unexpected type');
            }

            $origParamClone = clone $origParam;
            $origParamClone->flags = 0;
            $params[] = new Node\Arg(
                new Node\Expr\StaticCall(new Node\Name('\\'.RtInternalTracer::class), 'traceMethodParam', [
                    $origParamClone->var,
                    new String_($class->name?->name ?? '#unknown'),
                    new String_($clone->name->name),
                    new String_($origParam->var->name),
                    new LNumber($i),
                    new LNumber($origParam->var->getStartLine()),
                    new LNumber($origParam->var->getEndLine()),
                    new String_($this->file),
                ])
            );
        }


        $methodCall = new Node\Expr\MethodCall(
            new Node\Expr\Variable('this'),
            new Node\Identifier($newFunctioName),
            // todo, support variadics?
            $params
        );

        $classMethod->stmts = [
            ($returnsVoid
                ? new Node\Stmt\Expression($methodCall)
                : new Node\Stmt\Return_(
                    new Node\Expr\StaticCall(new Node\Name('\\'.RtInternalTracer::class), 'traceMethodReturn', [
                        $methodCall,
                        new String_($class->name?->name ?? '#unknown'),
                        new String_($clone->name->name),
                        new LNumber($clone->getStartLine()),
                        new LNumber($clone->getEndLine()),
                        new String_($this->file),
                    ])
                )
            ),
        ];
    }
}