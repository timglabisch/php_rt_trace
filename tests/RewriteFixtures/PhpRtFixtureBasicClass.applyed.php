<?php

declare (strict_types=1);
namespace Tests\timglabisch\PhpRtTrace\RewriteFixtures;

use timglabisch\PhpRtTrace\Log\RtLogFileInfo;
class PhpRtFixtureBasicClass
{
    private \SplFixedArray|int|null|string|\timglabisch\PhpRtTrace\Log\RtLogFileInfo $a = null;
    public function __construct($a)
    {
        $this->a = $a;
    }
}
new PhpRtFixtureBasicClass(123);
new PhpRtFixtureBasicClass("123");
new PhpRtFixtureBasicClass("123");
new PhpRtFixtureBasicClass(new \SplFixedArray());
new PhpRtFixtureBasicClass(new RtLogFileInfo('a', 'b', 'c'));