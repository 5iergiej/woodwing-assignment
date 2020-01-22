<?php

namespace WoodWing\Domain;

use InvalidArgumentException;

/**
 * Class Distance
 * @package WoodWing\Domain
 */
class Distance
{
    /** @var float */
    private $value;

    /** @var DistanceUnit */
    private $unit;

    /**
     * Distance constructor.
     * @param float $value
     * @param DistanceUnit $unit
     */
    public function __construct(float $value, DistanceUnit $unit)
    {
        $this->value = $value;
        $this->unit = $unit;
    }

    /**
     * @return float
     */
    public function getValue(): float
    {
        return $this->value;
    }

    /**
     * @return DistanceUnit
     */
    public function getUnit(): DistanceUnit
    {
        return $this->unit;
    }

    /**
     * Will add another distance and return the result.
     *
     * @param Distance $anotherDistance
     * @return Distance
     * @throws InvalidArgumentException if distance units are not the same
     */
    public function add (Distance $anotherDistance): Distance
    {
        if (!$this->unit->equals($anotherDistance->getUnit())) {
            throw new InvalidArgumentException("Not the same distance units can not be added.");
        }

        return new Distance($this->value + $anotherDistance->value, $this->unit);
    }
}