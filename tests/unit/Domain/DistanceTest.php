<?php

use PHPUnit\Framework\TestCase;
use WoodWing\Domain\Distance;
use WoodWing\Domain\DistanceUnit;

class DistanceTest extends TestCase
{
    public function testDistancesWithSameUnitsAreAddedSuccessfully(): void
    {
        $meter = new DistanceUnit(DistanceUnit::METER);
        $distance1 = new Distance(1, $meter);
        $distance2 = new Distance(2, $meter);
        $sum = new Distance(3, $meter);

        $this->assertEquals($sum, $distance1->add($distance2));
        $this->assertEquals($sum, $distance2->add($distance1));
    }

    public function testDistancesWithDifferentUnitsCanNotBeAdded(): void
    {
        $distance1 = new Distance(1, new DistanceUnit(DistanceUnit::METER));
        $distance2 = new Distance(1, new DistanceUnit(DistanceUnit::YARD));

        $this->expectException(InvalidArgumentException::class);

        $distance1->add($distance2);
    }
}