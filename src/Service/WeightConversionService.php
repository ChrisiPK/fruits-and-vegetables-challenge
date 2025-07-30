<?php

namespace App\Service;

use ValueError;

class WeightConversionService {
    public function convert(int $value, string $fromUnit, string $toUnit): int {
        switch([$fromUnit, $toUnit]) {
            case ["g", "kg"]:
                return intdiv($value, 1000);
            case ["kg", "g"]:
                if ($value > intdiv(PHP_INT_MAX, 1000) || $value < intdiv(PHP_INT_MIN, 1000)) {
                    throw new ValueError("Cannot convert, value out of range!");
                }
                return $value * 1000;
            case ["kg", "kg"]:
            case ["g", "g"]:
                return $value;
            default:
                throw new ValueError("Conversion between {$fromUnit} and {$toUnit} not implemented!");
        }
    }
}