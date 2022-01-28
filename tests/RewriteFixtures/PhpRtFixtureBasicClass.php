<?php

declare(strict_types=1);

namespace Tests\timglabisch\PhpRtTrace\RewriteFixtures;

class PhpRtFixtureBasicClass
{
    private $a;

    public function __construct($a)
    {
        $this->a = $a;
    }

}

new PhpRtFixtureBasicClass(123);
new PhpRtFixtureBasicClass("123");
new PhpRtFixtureBasicClass("123");
