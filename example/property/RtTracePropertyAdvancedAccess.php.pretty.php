<?php

namespace example\property;

define('__RTc8d2065678cdd5dec24b0ff5ab3fa72b', array('RTc8d2065678cdd5dec24b0ff5ab3fa72b', '{"opcode":6,"id":"RTc8d2065678cdd5dec24b0ff5ab3fa72b","filename":"\\/Users\\/timglabisch\\/proj\\/php\\/php_rt_trace\\/tests\\/..\\/example\\/property\\/RtTracePropertyAdvancedAccess.php","hash":"8ab0c47d40f0b6d183a0f667ff98fe1e"}'));
class RtTracePropertyAdvancedAccess
{
    private $a = 1;
    private $b = [];
    private function foo()
    {
        \timglabisch\PhpRtTrace\RtInternalTracer::tracePropertyFetch($this->a++, __CLASS__, 'a', 11, 11, __RTc8d2065678cdd5dec24b0ff5ab3fa72b);
        $this->a = \timglabisch\PhpRtTrace\RtInternalTracer::tracePropertyAssign(\timglabisch\PhpRtTrace\RtInternalTracer::tracePropertyFetch($this->a++, __CLASS__, 'a', 12, 12, __RTc8d2065678cdd5dec24b0ff5ab3fa72b), __CLASS__, 'a', 12, 12, __RTc8d2065678cdd5dec24b0ff5ab3fa72b);
        $this->a = \timglabisch\PhpRtTrace\RtInternalTracer::tracePropertyAssign($this->a = \timglabisch\PhpRtTrace\RtInternalTracer::tracePropertyAssign(\timglabisch\PhpRtTrace\RtInternalTracer::tracePropertyFetch($this->a++, __CLASS__, 'a', 13, 13, __RTc8d2065678cdd5dec24b0ff5ab3fa72b), __CLASS__, 'a', 13, 13, __RTc8d2065678cdd5dec24b0ff5ab3fa72b), __CLASS__, 'a', 13, 13, __RTc8d2065678cdd5dec24b0ff5ab3fa72b);
        // foo could not get a reference to $this->a because $this->a++ is a statement that you cant pass as a reference.
        foo(\timglabisch\PhpRtTrace\RtInternalTracer::tracePropertyFetch($this->a++, __CLASS__, 'a', 15, 15, __RTc8d2065678cdd5dec24b0ff5ab3fa72b));
        \timglabisch\PhpRtTrace\RtInternalTracer::tracePropertyFetch(++$this->a, __CLASS__, 'a', 16, 16, __RTc8d2065678cdd5dec24b0ff5ab3fa72b);
        \timglabisch\PhpRtTrace\RtInternalTracer::tracePropertyFetch(--$this->a, __CLASS__, 'a', 17, 17, __RTc8d2065678cdd5dec24b0ff5ab3fa72b);
        \timglabisch\PhpRtTrace\RtInternalTracer::tracePropertyFetch($this->a--, __CLASS__, 'a', 18, 18, __RTc8d2065678cdd5dec24b0ff5ab3fa72b);
        /*
        $this->a += 1;
        $this->a -= 1;
        $this->a *= 1;
        $this->b['a']['b'];
        shuffle($this->b);
        shuffle($this->b[0]);
        shuffle($this->b + [a]);
        $this->a ??= 1;
        $a = $this->a ? 1 : 2;
        $this->{'a'} = 1;
        */
    }
}