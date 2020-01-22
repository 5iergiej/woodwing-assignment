<?php

use PHPUnit\Framework\TestCase;
use WoodWing\Application\Service\DistanceCalculatorService;
use WoodWing\Domain\Distance;
use WoodWing\Domain\DistanceUnit;

class DistanceCalculatorServiceTest extends TestCase
{
    public function testConverterWorksCorrectly(): void
    {
        $service = new DistanceCalculatorService();
        $meter = new DistanceUnit(DistanceUnit::METER);
        $yard = new DistanceUnit(DistanceUnit::YARD);

        $oneMeter = new Distance(1, $meter);
        $oneYard = new Distance(1, $yard);

        $this->assertEquals(new Distance(1.0936133, $yard), $service->convertDistance($oneMeter, $yard));
        $this->assertEquals(new Distance(0.9144, $meter), $service->convertDistance($oneYard, $meter));
    }

    public function testDistancesAreAddedCorrectly(): void
    {
        $service = new DistanceCalculatorService();
        $meter = new DistanceUnit(DistanceUnit::METER);
        $yard = new DistanceUnit(DistanceUnit::YARD);

        $distances = [
            new Distance(1, $meter),
            new Distance(3, $meter),
            new Distance(1, $yard),
            new Distance(-5, $meter),
            new Distance(-1, $yard)
        ];

        // we need delta because of the float comparison
        $this->assertEqualsWithDelta(new Distance(-1.0936133, $yard), $service->calculateSum($distances, $yard), 0.00001);
        $this->assertEqualsWithDelta(new Distance(-1, $meter), $service->calculateSum($distances, $meter), 0.00001);
    }
}