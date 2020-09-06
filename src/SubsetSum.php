<?php


namespace SubsetSum;


use SubsetSum\Comparable\ClosestComparable;

class SubsetSum
{
    public static function createWithRepetition($set, $target, $config = []): Subset
    {
        $config += [
            'step' => 1,
            'comparable' => new ClosestComparable()
        ];
        $targetSet = [];
        for ($i = 0; $i <= $target; $i += $config['step']) {
            $targetSet[] = $i;
        }
        return TargetOverSetTable::create($set, $targetSet, $config['comparable']);
    }

    public static function create($set, $target, $config = []): Subset
    {
        $config += [
            'step' => 1,
            'comparable' => new ClosestComparable()
        ];
        $targetSet = [];
        for ($i = 0; $i <= $target; $i += $config['step']) {
            $targetSet[] = $i;
        }
        return SetOverTargetTable::create($set, $targetSet, $config['comparable']);
    }
}