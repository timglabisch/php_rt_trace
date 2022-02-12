<?php

declare (strict_types=1);
define('__RT0940669850e41db963a466987b31747f', array('RT0940669850e41db963a466987b31747f', '{"opcode":6,"id":"RT0940669850e41db963a466987b31747f","filename":"\\/Users\\/timglabisch\\/proj\\/php\\/php_rt_trace\\/tests\\/..\\/example\\/method\\/RtTraceExampleMethodBasic.php","hash":"6ef4423a3ee07fdff4b7fc208c063e9a"}'));
class RtTraceExampleMethodBasic
{
    function foo($a, int $b) : void
    {
        $this->fooBar($a, $b);
    }
    #[Foo]
    function fooMixed($a, $b) : mixed
    {
        return $this->fooBar($a, $b);
    }
    function fooBar($a, $b) : mixed
    {
        return $a;
    }
}