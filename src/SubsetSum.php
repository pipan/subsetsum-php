<?php


namespace SubsetSum;


use SubsetSum\Comparable\ClosestComparable;

class SubsetSum
{
    public static function createWithRepetition($set, $target, $config = []): SubsetTableResult
    {
        return SubsetSum::builder()
            ->withSet($set)
            ->withTargetSpaced($target, $config['step'] ?? 1)
            ->withComparable($config['comparable'] ?? new ClosestComparable())
            ->withExactSum($config['exact'] ?? false)
            ->buildWithRepetition();
    }

    public static function create($set, $target, $config = []): SubsetTableResult
    {
        return SubsetSum::builder()
            ->withSet($set)
            ->withTargetSpaced($target, $config['step'] ?? 1)
            ->withComparable($config['comparable'] ?? new ClosestComparable())
            ->withExactSum($config['exact'] ?? false)
            ->build();
    }

    public static function builder(): SubsetSumBuilder
    {
        return new SubsetSumBuilder();
    }
}