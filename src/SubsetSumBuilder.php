<?php


namespace SubsetSum;


use SubsetSum\Comparable\ClosestComparable;
use SubsetSum\Comparable\Comparable;
use SubsetSum\Comparable\ComparableFunction;

class SubsetSumBuilder
{
    private $set;
    private $targetSet = [];
    private $comparable;

    public function __construct()
    {
        $this->comparable = new ClosestComparable();
    }

    public function withSet($set)
    {
        $this->set = $set;
        return $this;
    }

    public function withTargetSet($set)
    {
        $this->targetSet = $set;
        return $this;
    }

    public function withTarget($target, $spacing = 1)
    {
        $set = [];
        for ($i = 0; $i <= $target; $i += $spacing) {
            $set[] = $i;
        }
        return $this->withTargetSet($set);
    }

    public function withComparable(Comparable $comparable)
    {
        $this->comparable = $comparable;
        return $this;
    }

    public function withComparableFunction($fn)
    {
        return $this->withComparable(
            new ComparableFunction($fn)
        );
    }

//    private function createTargetSetFromSet($set)
//    {
//        if (count($set) <= 1) {
//            return $set;
//        }
//        $commonDivisor = $set[0];
//        for ($i = 1; $i < count($set); $i++) {
//            $commonDivisor = gmp_gcd($commonDivisor, $set[$i]);
//        }
//        $targetSet = [];
//        for ($i = 0; $i <= $set[count($set) - 1]; $i += $commonDivisor) {
//            $targetSet[] = $i;
//        }
//        return $targetSet;
//    }

    public function build()
    {
//        $targetSet = $this->targetSet;
//        if (empty($targetSet)) {
//            $targetSet = $this->createTargetSetFromSet($this->set);
//        }
        return SetOverTargetTable::create($this->set, $targetSet, $this->comparable);
    }

    public function buildWithRepetition()
    {
//        $targetSet = $this->targetSet;
//        if (empty($targetSet)) {
//            $targetSet = $this->createTargetSetFromSet($this->set);
//        }
        return TargetOverSetTable::create($this->set, $targetSet, $this->comparable);
    }
}