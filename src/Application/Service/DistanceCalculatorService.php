<?php

namespace WoodWing\Application\Service;

use WoodWing\Domain\Distance;
use WoodWing\Domain\DistanceUnit;

class DistanceCalculatorService
{
    private const YARD_TO_METER_RATIO = 0.9144;
    private const METER_TO_YARD_RATIO = 1.0936133;

    /**
     * @param Distance $distance
     * @param DistanceUnit $desiredUnit
     * @return Distance
     */
    public function convertDistance(Distance $distance, DistanceUnit $desiredUnit): Distance
    {
        if ($distance->getUnit()->equals($desiredUnit)) {
            return $distance;
        }

        switch ($desiredUnit->getValue()) {
            case DistanceUnit::YARD:
                return new Distance($distance->getValue() * self::METER_TO_YARD_RATIO, $desiredUnit);
            case DistanceUnit::METER:
                return new Distance($distance->getValue() * self::YARD_TO_METER_RATIO, $desiredUnit);
        }
    }

    /**
     * @param Distance[] $distances
     * @param DistanceUnit $desiredUnit
     * @return Distance
     */
    public function calculateSum(array $distances, DistanceUnit $desiredUnit): Distance
    {
        $result = new Distance(0, $desiredUnit);

        foreach ($distances as $distance) {
            if (!$distance->getUnit()->equals($desiredUnit)) {
                $distance = $this->convertDistance($distance, $desiredUnit);
            }

            $result = $result->add($distance);
        }

        return $result;
    }
}