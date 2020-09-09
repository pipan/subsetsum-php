<?php


namespace SubsetSum;

use InvalidArgumentException;

class TargetSet
{
    public static function evenlySpaced($target, $spacing)
    {
        if ($target < 0) {
            throw new InvalidArgumentException("Target cannot be negative number");
        }

        if ($spacing < 0) {
            throw new InvalidArgumentException("Target spacing cannot be negative number");
        }

        if ($spacing === 0) {
            throw new InvalidArgumentException("Target spacing cannot be zero");
        }
        $targetSet = [];
        for ($i = 0; $i <= $target; $i += $spacing) {
            $targetSet[] = $i;
        }
        return $targetSet;
    }

    public static function fromSet($target, $set)
    {
        if (!function_exists('gmp_gcd')) {
            return TargetSet::evenlySpaced($target, 1);
        }
        if (count($set) === 0) {
            return TargetSet::evenlySpaced($target, 1);
        }
        $spacing = $set[0];
        foreach ($set as $value) {
            $spacing = gmp_gcd($spacing, $value);
        }
        return TargetSet::evenlySpaced($target, $spacing);
    }
}