<?php

declare (strict_types=1);
namespace Tests\timglabisch\PhpRtTrace\RewriteFixtures;

class PhpRtFixtureBasicClass
{
    private int|string $a;
    public function __construct($a)
    {
        $this->a = $a;
    }
}
new \Tests\timglabisch\PhpRtTrace\RewriteFixtures\PhpRtFixtureBasicClass(123);
new \Tests\timglabisch\PhpRtTrace\RewriteFixtures\PhpRtFixtureBasicClass("123");
new \Tests\timglabisch\PhpRtTrace\RewriteFixtures\PhpRtFixtureBasicClass("123");