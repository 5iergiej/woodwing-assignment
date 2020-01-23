<?php

namespace WoodWing\Application\Controller\DistanceCalculator;

use WoodWing\Application\Exception\AssertionError;

class DistanceInputValidator
{
    /**
     * @param array $input
     * @throws AssertionError
     */
    public static function validate(array $input): void
    {
        if (!array_key_exists('distances', $input)) {
            throw new AssertionError('Distance key is missing');
        }

        if (!array_key_exists('resultUnit', $input)) {
            throw new AssertionError('resultUnit key is missing');
        }

        if (!is_array($input['distances'])) {
            throw new AssertionError('At least 2 distances must be provided');
        }

        foreach ($input['distances'] as $index => $distance) {
            try {
                self::validateDistanceItem($distance);
            } catch (AssertionError $exception) {
                throw new AssertionError('Invalid distance at position: ' . $index);
            }
        }
    }

    /**
     * @param array $distance
     * @throws AssertionError
     */
    private static function validateDistanceItem(array $distance): void
    {
        if (!array_key_exists('distance', $distance)) {
            throw new AssertionError('Invalid distance');
        }

        if (!array_key_exists('unit', $distance)) {
            throw new AssertionError('Invalid distance');
        }

        if (!is_numeric($distance['distance'])) {
            throw new AssertionError('Invalid distance');
        }
    }
}