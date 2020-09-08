<?php


namespace SubsetSum\Comparable;


use SubsetSum\TargetNode;

class PreferLowerSumComparable implements Comparable
{
    public function compare(TargetNode $a, TargetNode $b)
    {
        if ($a->getValue() == $b->getValue()) {
            return count($a->getSubset()) <= count($b->getSubset()) ? $a : $b;
        }
        
        if ($a->getValue() >= 0 && $b->getValue() >= 0) {
            return ($a->getValue() <= $b->getValue()) ? $a : $b;
        }
        return ($a->getValue() >= $b->getValue()) ? $a : $b;
    }
}