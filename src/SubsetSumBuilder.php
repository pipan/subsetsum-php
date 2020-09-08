<?php


namespace SubsetSum;


use SubsetSum\Comparable\ClosestComparable;
use SubsetSum\Comparable\Comparable;
use SubsetSum\Comparable\ComparableFunction;
use SubsetSum\Comparable\PreferGreaterSumComparable;
use SubsetSum\Comparable\PreferLowerSumComparable;

class SubsetSumBuilder
{
    private $set;
    private $targetSet = [];
    private $target;
    private $targetSpacing;
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

    public function withTarget($target)
    {
        return $this->withTargetSpaced($target, null);
    }

    public function withTargetSpaced($target, $spacing)
    {
        $this->target = $target;
        $this->targetSpacing = $spacing;
        return $this;
    }

    public function preferGreaterSum()
    {
        return $this->withComparable(new PreferGreaterSumComparable());
    }

    public function preferLowerSum()
    {
        return $this->withComparable(new PreferLowerSumComparable());
    }

    public function onlyExactSum()
    {

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

    private function getTargetSet()
    {
        if (!empty($targetSet)) {
            return $this->targetSet;
        }
        if ($this->targetSpacing !== null) {
            return TargetSet::evenlySpaced($this->target, $this->targetSpacing);
        }
        return TargetSet::fromSet($this->target, $this->set);
    }

    public function build()
    {
        return SetsTable::create($this->set, $this->getTargetSet(), $this->comparable);
    }

    public function buildWithRepetition()
    {
        return TargetsTable::create($this->set, $this->getTargetSet(), $this->comparable);
    }
}