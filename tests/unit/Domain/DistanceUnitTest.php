<?php

use PHPUnit\Framework\TestCase;
use WoodWing\Domain\DistanceUnit;

class DistanceUnitTest extends TestCase
{
    /**
     * @dataProvider validDistanceUnits
     */
    public function testDistanceUnitObjectIsSuccessfullyCreatedWithValidValue(string $validValue): void
    {
        $distanceUnit = new DistanceUnit($validValue);
        $this->assertInstanceOf(DistanceUnit::class, $distanceUnit);
    }

    /**
     * @dataProvider invalidDistanceUnits
     */
    public function testDistanceUnitObjectCanNotBeCreatedWithInvalidValue(string $invalidValue): void
    {
        $this->expectException(InvalidArgumentException::class);

        new DistanceUnit($invalidValue);
    }

    public function testSameDistanceUnitsAreEqual(): void
    {
        $unit1 = new DistanceUnit(DistanceUnit::METER);
        $unit2 = new DistanceUnit(DistanceUnit::METER);
        $this->assertTrue($unit1->equals($unit2));
        $this->assertTrue($unit2->equals($unit1));
    }

    public function testDifferentDistanceUnitsAreNotEqual(): void
    {
        $unit1 = new DistanceUnit(DistanceUnit::METER);
        $unit2 = new DistanceUnit(DistanceUnit::YARD);
        $this->assertFalse($unit1->equals($unit2));
        $this->assertFalse($unit2->equals($unit1));
    }

    public function validDistanceUnits(): array
    {
        return [
            'm' => ['m'],
            'yd' => ['yd']
        ];
    }

    public function invalidDistanceUnits(): array
    {
        return [
            'nm' => ['nm'],
            'mm' => ['mm'],
            'cm' => ['cm'],
            'dm' => ['dm'],
            'ft' => ['ft']
        ];
    }
}