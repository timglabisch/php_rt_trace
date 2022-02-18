<?php

namespace example\property;

define('__RTcb81f4578ffab93b23262732373c42bd', array('RTcb81f4578ffab93b23262732373c42bd', '{"opcode":6,"id":"RTcb81f4578ffab93b23262732373c42bd","filename":"\\/usr\\/share\\/nginx\\/devel_sf\\/vendor\\/timglabisch\\/php_rt_trace\\/tests\\/..\\/example\\/property\\/RtTracePropertyAdvancedAccess.php","hash":"92a47a71147ecef6aadad9ccf7f68f44"}'));
class RtTracePropertyAdvancedAccess
{
    private $a = 1;
    private $b = [];
    private function foo()
    {
        (fn() => array(shuffle($this->b), \timglabisch\PhpRtTrace\RtInternalTracer::tracePropertyFetch($this->b, __CLASS__, 'b', 11, 11, __RTcb81f4578ffab93b23262732373c42bd)))()[0];
        shuffle(\timglabisch\PhpRtTrace\RtInternalTracer::tracePropertyFetch($this->b, __CLASS__, 'b', 12, 12, __RTcb81f4578ffab93b23262732373c42bd)[0]);
        isset($this->{'b'});
        (function () {
            if (!isset($this->b)) {
                return false;
            }
            \timglabisch\PhpRtTrace\RtInternalTracer::tracePropertyFetch($this->b, __CLASS__, 'b', 14, 14, __RTcb81f4578ffab93b23262732373c42bd);
            return true;
        })();
        (function () {
            if (!isset($this->b)) {
                return false;
            }
            \timglabisch\PhpRtTrace\RtInternalTracer::tracePropertyFetch($this->b, __CLASS__, 'b', 15, 15, __RTcb81f4578ffab93b23262732373c42bd);
            return true;
        })() && (function () {
            if (!isset($this->a)) {
                return false;
            }
            \timglabisch\PhpRtTrace\RtInternalTracer::tracePropertyFetch($this->a, __CLASS__, 'a', 15, 15, __RTcb81f4578ffab93b23262732373c42bd);
            return true;
        })();
        $x = isset(\timglabisch\PhpRtTrace\RtInternalTracer::tracePropertyFetch($this->b, __CLASS__, 'b', 16, 16, __RTcb81f4578ffab93b23262732373c42bd)[(function () {
            if (!isset($this->a)) {
                return false;
            }
            \timglabisch\PhpRtTrace\RtInternalTracer::tracePropertyFetch($this->a, __CLASS__, 'a', 16, 16, __RTcb81f4578ffab93b23262732373c42bd);
            return true;
        })()]);
        empty(\timglabisch\PhpRtTrace\RtInternalTracer::tracePropertyFetch($this->b, __CLASS__, 'b', 19, 19, __RTcb81f4578ffab93b23262732373c42bd));
        foo(\timglabisch\PhpRtTrace\RtInternalTracer::tracePropertyFetch($this->b, __CLASS__, 'b', 20, 20, __RTcb81f4578ffab93b23262732373c42bd) + ['a']);
        // todo we could trace this the easy way
        \timglabisch\PhpRtTrace\RtInternalTracer::tracePropertyFetch(
            // todo we could trace this the easy way
            $this->a ??= 1,
            __CLASS__,
            'a',
            21,
            21,
            __RTcb81f4578ffab93b23262732373c42bd
        );
        $a = \timglabisch\PhpRtTrace\RtInternalTracer::tracePropertyFetch($this->a, __CLASS__, 'a', 22, 22, __RTcb81f4578ffab93b23262732373c42bd) ? 1 : 2;
        $this->{'a'} = 1;
        // todo, is this fine with uninitialized properties?
        $x = \timglabisch\PhpRtTrace\RtInternalTracer::tracePropertyFetch($this->a, __CLASS__, 'a', 25, 25, __RTcb81f4578ffab93b23262732373c42bd) ?? \timglabisch\PhpRtTrace\RtInternalTracer::tracePropertyFetch($this->b, __CLASS__, 'b', 25, 25, __RTcb81f4578ffab93b23262732373c42bd) ?? $this->c ?? null;
    }
}