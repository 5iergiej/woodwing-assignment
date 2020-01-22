<?php

namespace WoodWing\Domain;

use InvalidArgumentException;

/**
 * Class DistanceUnit
 * @package WoodWing\Domain
 *
 * Value object for the distance unit
 */
class DistanceUnit
{
    /**
     * SI names of the distance units to be used as enum values
     */
    public const METER = 'm';
    public const YARD = 'yd';

    private const ALLOWED_VALUES = [
        self::METER,
        self::YARD
    ];

    /** @var string */
    private $value;

    /**
     * DistanceUnit constructor.
     * @param string $value
     */
    public function __construct(string $value)
    {
        $this->validate($value);
        $this->value = $value;
    }

    /**
     * @return string
     */
    public function getValue(): string
    {
        return $this->value;
    }

    /**
     * @param DistanceUnit $anotherDistanceUnit
     * @return bool
     */
    public function equals(DistanceUnit $anotherDistanceUnit): bool
    {
        return $this->value === $anotherDistanceUnit->getValue();
    }

    /**
     * @param string $value
     * @throws InvalidArgumentException
     */
    private function validate(string $value): void {
        if (!in_array($value, self::ALLOWED_VALUES, true)) {
            throw new InvalidArgumentException("Invalid distance unit: " . $value);
        }
    }
}