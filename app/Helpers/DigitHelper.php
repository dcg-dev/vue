<?php

namespace App\Helpers;

class DigitHelper {

    /**
     * Calculate growth between two digits
     *
     * @param mixed $numberOne
     * 
     * @param mixed $numberTwo
     * 
     * @return void
     */
    public static function calculateGrowth($numberOne, $numberTwo) {
        if (!$numberOne && !$numberTwo) {
            return 0;
        }
        return $numberTwo ? round((($numberOne - $numberTwo) / $numberTwo) * 100, 2) : 100; //to percent
    }

}
