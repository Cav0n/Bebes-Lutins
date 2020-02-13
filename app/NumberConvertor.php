<?php

namespace App;


class NumberConvertor
{
    /**
     * @param double $number The number to convert
     */
    public static function doubleToPrice($number): string
    {
        return number_format($number, 2, ",", " ") . ' €';
    }
}
