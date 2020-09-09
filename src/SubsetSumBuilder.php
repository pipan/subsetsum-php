<?php


namespace SubsetSum;

use InvalidArgumentException;
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
    private $exactMatch = false;

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
        return $this->withTargetSpaced($target, 1);
    }

    public function withTargetSpaced($target, $spacing)
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
        return $this->withExactSum(true);
    }

    public function withExactSum($enabled)
    {
        $this->exactMatch = $enabled;
        return $this;
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
        if (!empty($this->targetSet)) {
            return $this->targetSet;
        }
        return TargetSet::evenlySpaced($this->target, $this->targetSpacing);
    }

    public function build()
    {
        return $this->getTable(
            SetsTable::create($this->set, $this->getTargetSet(), $this->comparable)
        );
    }

    public function buildWithRepetition()
    {
        return $this->getTable(
            TargetsTable::create($this->set, $this->getTargetSet(), $this->comparable)
        );
    }

    private function getTable($table)
    {
        if (!$this->exactMatch) {
            return $table;
        }
        return new ExactMatchSubset($table);
    }
}