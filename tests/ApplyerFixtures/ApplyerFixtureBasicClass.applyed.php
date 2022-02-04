<?php

declare (strict_types=1);
namespace Tests\timglabisch\PhpRtTrace\ApplyerFixtures;

class ApplyerFixtureBasicClass
{
    private int $c = 12;
    private float $d = 12.0;
    private string $e = 'foo';
    private string $f = \Tests\timglabisch\PhpRtTrace\ApplyerFixtures\ApplyerFixtureBasicClass::class;
    private array $g = [];
    private $h = null;
    private int|string $a;
    private int $b;
}