<?php


namespace SubsetSum\Comparable;


use SubsetSum\TargetNode;

class ClosestComparable implements Comparable
{
    public function compare(TargetNode $a, TargetNode $b)
    {
        if (abs($a->getValue()) == abs($b->getValue())) {
            return count($a->getSubset()) <= count($b->getSubset()) ? $a : $b;
        }
        return abs($a->getValue()) <= abs($b->getValue()) ? $a : $b;
    }
}