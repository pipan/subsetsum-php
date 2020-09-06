<?php


namespace SubsetSum\Comparable;


use SubsetSum\TargetNode;

class ClosestComparable implements Comparable
{
    public function compare(TargetNode $a, TargetNode $b)
    {
        return abs($a->getValue()) <= abs($b->getValue()) ? $a : $b;
    }
}