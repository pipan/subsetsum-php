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

    public static function fromSet($target, $set)
    {
        sort($set);

        if ($set[count($set) - 1] < $target) {
            $set[] = $target;
        }

        $prev = 0;
        $spacing = null;
        foreach ($set as $value) {
            $diff = $value - $prev;
            if ($diff > 0 && ($diff === null || $diff < $spacing)) {
                $spacing = $diff;
            }
            $prev = $value;
        }

        return TargetSet::evenlySpaced($target, $spacing);
    }
}