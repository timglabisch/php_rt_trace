<?php

declare (strict_types=1);
namespace Tests\timglabisch\PhpRtTrace\ApplyerFixtures;

class ApplyerFixtureBasicClass
{
    private int|null|string $a = null;
    private $x = null;
    private $c = 12;
    private $d = 12.0;
    private $e = 'foo';
    private $f = \Tests\timglabisch\PhpRtTrace\ApplyerFixtures\ApplyerFixtureBasicClass::class;
    private $g = [];
    private $h = null;
    private int $b;
}