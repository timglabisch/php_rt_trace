<?php

namespace example\property;

if (!defined('__RTcb81f4578ffab93b23262732373c42bd')) {
    define('__RTcb81f4578ffab93b23262732373c42bd', array('RTcb81f4578ffab93b23262732373c42bd', '{"opcode":6,"id":"RTcb81f4578ffab93b23262732373c42bd","filename":"\\/usr\\/share\\/nginx\\/devel_sf\\/vendor\\/timglabisch\\/php_rt_trace\\/tests\\/..\\/example\\/property\\/RtTracePropertyAdvancedAccess.php","hash":"4d9b4ec805fe7848cf220b027a4c5745"}'));
}
class RtTracePropertyAdvancedAccess
{
    private $a = 1;
    private $b = [];
    private function foo()
    {
        unset($this->b['x']);
        unset($this->b);
        $this->b =& $a;
        $this->b =& $this->a;
        \timglabisch\PhpRtTrace\RtInternalTracer::tracePropertyFetch($this->b &= $a, __CLASS__, 'b', 15, 15, __RTcb81f4578ffab93b23262732373c42bd);
        \timglabisch\PhpRtTrace\RtInternalTracer::tracePropertyFetch($this->b &= $this->a, __CLASS__, 'b', 16, 16, __RTcb81f4578ffab93b23262732373c42bd);
        $this->b['x'] = 'a';
        \timglabisch\PhpRtTrace\RtInternalTracer::tracePropertyFetch($this->a++, __CLASS__, 'a', 18, 18, __RTcb81f4578ffab93b23262732373c42bd);
        $this->a = \timglabisch\PhpRtTrace\RtInternalTracer::tracePropertyAssign(\timglabisch\PhpRtTrace\RtInternalTracer::tracePropertyFetch($this->a++, __CLASS__, 'a', 19, 19, __RTcb81f4578ffab93b23262732373c42bd), __CLASS__, 'a', 19, 19, __RTcb81f4578ffab93b23262732373c42bd);
        $this->a = \timglabisch\PhpRtTrace\RtInternalTracer::tracePropertyAssign($this->a = \timglabisch\PhpRtTrace\RtInternalTracer::tracePropertyAssign(\timglabisch\PhpRtTrace\RtInternalTracer::tracePropertyFetch($this->a++, __CLASS__, 'a', 20, 20, __RTcb81f4578ffab93b23262732373c42bd), __CLASS__, 'a', 20, 20, __RTcb81f4578ffab93b23262732373c42bd), __CLASS__, 'a', 20, 20, __RTcb81f4578ffab93b23262732373c42bd);
        // foo could not get a reference to $this->a because $this->a++ is a statement that you cant pass as a reference.
        foo(\timglabisch\PhpRtTrace\RtInternalTracer::tracePropertyFetch($this->a++, __CLASS__, 'a', 22, 22, __RTcb81f4578ffab93b23262732373c42bd));
        \timglabisch\PhpRtTrace\RtInternalTracer::tracePropertyFetch(++$this->a, __CLASS__, 'a', 23, 23, __RTcb81f4578ffab93b23262732373c42bd);
        \timglabisch\PhpRtTrace\RtInternalTracer::tracePropertyFetch(--$this->a, __CLASS__, 'a', 24, 24, __RTcb81f4578ffab93b23262732373c42bd);
        $this->b = \timglabisch\PhpRtTrace\RtInternalTracer::tracePropertyAssign(\timglabisch\PhpRtTrace\RtInternalTracer::tracePropertyFetch($this->b, __CLASS__, 'b', 25, 25, __RTcb81f4578ffab93b23262732373c42bd)[\timglabisch\PhpRtTrace\RtInternalTracer::tracePropertyFetch($this->a++, __CLASS__, 'a', 25, 25, __RTcb81f4578ffab93b23262732373c42bd)][\timglabisch\PhpRtTrace\RtInternalTracer::tracePropertyFetch($this->a++, __CLASS__, 'a', 25, 25, __RTcb81f4578ffab93b23262732373c42bd)], __CLASS__, 'b', 25, 25, __RTcb81f4578ffab93b23262732373c42bd);
        \timglabisch\PhpRtTrace\RtInternalTracer::tracePropertyFetch($this->a--, __CLASS__, 'a', 26, 26, __RTcb81f4578ffab93b23262732373c42bd);
        \timglabisch\PhpRtTrace\RtInternalTracer::tracePropertyFetch($this->a += 1, __CLASS__, 'a', 27, 27, __RTcb81f4578ffab93b23262732373c42bd);
        \timglabisch\PhpRtTrace\RtInternalTracer::tracePropertyFetch($this->a -= 1, __CLASS__, 'a', 28, 28, __RTcb81f4578ffab93b23262732373c42bd);
        \timglabisch\PhpRtTrace\RtInternalTracer::tracePropertyFetch($this->a *= 1, __CLASS__, 'a', 29, 29, __RTcb81f4578ffab93b23262732373c42bd);
        \timglabisch\PhpRtTrace\RtInternalTracer::tracePropertyFetch($this->b, __CLASS__, 'b', 30, 30, __RTcb81f4578ffab93b23262732373c42bd)['a']['b'];
        $this->b['a']['b']++;
        (fn() => array(shuffle($this->b), \timglabisch\PhpRtTrace\RtInternalTracer::tracePropertyFetch($this->b, __CLASS__, 'b', 32, 32, __RTcb81f4578ffab93b23262732373c42bd)))()[0];
        shuffle(\timglabisch\PhpRtTrace\RtInternalTracer::tracePropertyFetch($this->b, __CLASS__, 'b', 33, 33, __RTcb81f4578ffab93b23262732373c42bd)[0]);
        isset($this->{'b'});
        (function () {
            if (!isset($this->b)) {
                return false;
            }
            \timglabisch\PhpRtTrace\RtInternalTracer::tracePropertyFetch($this->b, __CLASS__, 'b', 35, 35, __RTcb81f4578ffab93b23262732373c42bd);
            return true;
        })();
        (function () {
            if (!isset($this->b)) {
                return false;
            }
            \timglabisch\PhpRtTrace\RtInternalTracer::tracePropertyFetch($this->b, __CLASS__, 'b', 36, 36, __RTcb81f4578ffab93b23262732373c42bd);
            return true;
        })() && (function () {
            if (!isset($this->a)) {
                return false;
            }
            \timglabisch\PhpRtTrace\RtInternalTracer::tracePropertyFetch($this->a, __CLASS__, 'a', 36, 36, __RTcb81f4578ffab93b23262732373c42bd);
            return true;
        })();
        $x = isset(\timglabisch\PhpRtTrace\RtInternalTracer::tracePropertyFetch($this->b, __CLASS__, 'b', 37, 37, __RTcb81f4578ffab93b23262732373c42bd)[(function () {
            if (!isset($this->a)) {
                return false;
            }
            \timglabisch\PhpRtTrace\RtInternalTracer::tracePropertyFetch($this->a, __CLASS__, 'a', 37, 37, __RTcb81f4578ffab93b23262732373c42bd);
            return true;
        })()]);
        empty(\timglabisch\PhpRtTrace\RtInternalTracer::tracePropertyFetch($this->b, __CLASS__, 'b', 38, 38, __RTcb81f4578ffab93b23262732373c42bd));
        foo(\timglabisch\PhpRtTrace\RtInternalTracer::tracePropertyFetch($this->b, __CLASS__, 'b', 39, 39, __RTcb81f4578ffab93b23262732373c42bd) + ['a']);
        // todo we could trace this the easy way
        \timglabisch\PhpRtTrace\RtInternalTracer::tracePropertyFetch(
            // todo we could trace this the easy way
            $this->a ??= 1,
            __CLASS__,
            'a',
            40,
            40,
            __RTcb81f4578ffab93b23262732373c42bd
        );
        $a = \timglabisch\PhpRtTrace\RtInternalTracer::tracePropertyFetch($this->a, __CLASS__, 'a', 41, 41, __RTcb81f4578ffab93b23262732373c42bd) ? 1 : 2;
        $this->{'a'} = 1;
        // todo, is this fine with uninitialized properties?
        $x = \timglabisch\PhpRtTrace\RtInternalTracer::tracePropertyFetch($this->a, __CLASS__, 'a', 44, 44, __RTcb81f4578ffab93b23262732373c42bd) ?? \timglabisch\PhpRtTrace\RtInternalTracer::tracePropertyFetch($this->b, __CLASS__, 'b', 44, 44, __RTcb81f4578ffab93b23262732373c42bd) ?? $this->c ?? null;
    }
}