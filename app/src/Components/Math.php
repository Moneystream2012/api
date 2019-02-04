<?php
/**
 * Created by PhpStorm.
 * User: Tarasenko Andrii
 * Date: 27.10.17
 * Time: 11:49
 */

namespace App\Components;


use App\Exceptions\MathException;

class Math
{
    /**
     * BCAdd - fixes a problem of BCMath and exponential numbers
     *
     * @param  string  $op1
     * @param  string  $op2
     * @param  integer $scale
     * @return string
     */
    public static function Add($op1, $op2, $scale = null)
    {
        $op1 = self::exponent($op1);
        $op2 = self::exponent($op2);
        return bcadd($op1, $op2, $scale);
    }

    /**
     * BCSub - fixes a problem of BCMath and exponential numbers
     *
     * @param  string  $op1
     * @param  string  $op2
     * @param  integer $scale
     * @return string
     */
    public static function Sub($op1, $op2, $scale = null)
    {
        $op1 = self::exponent($op1);
        $op2 = self::exponent($op2);
        return bcsub($op1, $op2, $scale);
    }

    /**
     * @param $op1
     * @param $op2
     * @param null $scale
     * @return int
     */
    public static function Comp($op1, $op2, $scale = null): int {
        $op1 = self::exponent($op1);
        $op2 = self::exponent($op2);
        return bccomp (  $op1,  $op2, $scale);
    }

    /**
     * Changes exponential numbers to plain string numbers
     * Fixes a problem of BCMath with numbers containing exponents
     *
     * @param integer $value Value to erase the exponent
     * @param integer $scale (Optional) Scale to use
     * @return string
     */
    public static function exponent($value, $scale = null)
    {
        $split = explode('e', $value);
        if (count($split) == 1) {
            $split = explode('E', $value);
        }
        if (count($split) > 1) {
            $value = bcmul($split[0], bcpow(10, $split[1], $scale), $scale);
        }
        return $value;
    }
}
