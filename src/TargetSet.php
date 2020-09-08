<?php


namespace SubsetSum;


class TargetSet
{
    public static function evenlySpaced($target, $spacing)
    {
        $targetSet = [];
        for ($i = 0; $i <= $target; $i += $spacing) {
            $targetSet[] = $i;
        }
        return $targetSet;
    }
}