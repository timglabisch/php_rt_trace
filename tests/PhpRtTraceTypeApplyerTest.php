<?php

declare(strict_types=1);

namespace tests;

use PHPUnit\Framework\TestCase;
use Tests\timglabisch\PhpRtTrace\ApplyerFixtures\ApplyerFixtureBasicClass;
use timglabisch\PhpRtTrace\LogReader\Dto\RtPropertyTypeMap;
use timglabisch\PhpRtTrace\TypeApplyer\RtTypeApplyer;

class PhpRtTraceTypeApplyerTest extends TestCase
{
    public function testApplyPropertyType(): void {
        $typeMap = new RtPropertyTypeMap([
            ApplyerFixtureBasicClass::class => [
                'a' => [
                    'types' => [
                        'int' => 1,
                        'string' => 1,
                    ]
                ],
                'b' => [
                    'types' => [
                        '\DateTime' => 1,
                    ]
                ]
            ]
        ]);

        $filename = __DIR__ . '/ApplyerFixtures/ApplyerFixtureBasicClass.php';

        $typeApplyer = RtTypeApplyer::newFromFile($filename);

        $typeApplyer->applyPropertyTypes($typeMap);

        $pretty = $typeApplyer->getPretty();

        $applyedFile = str_replace(['.php'], ['.applyed.php'], $filename);
        // file_put_contents(str_replace(['.php'], ['.applyed.php'], $filename), $pretty);

        static::assertEquals(file_get_contents($applyedFile), $pretty);
    }
}