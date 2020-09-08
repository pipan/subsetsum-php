<?php


namespace Tests\SubsetSumWithRepetition;


use PHPUnit\Framework\TestCase;
use SubsetSum\Comparable\PreferLowerSumComparable;
use SubsetSum\SubsetSum;
use SubsetSum\SubsetSumWithRepetition;

class SubsetSumWithRepetitionLowerThenTargetTest extends TestCase
{
    public function testSetOfOneEqualsToTarget()
    {
        $subset = SubsetSum::createWithRepetition([1], 100, [
            'comparable' => new PreferLowerSumComparable()
        ]);

        $this->assertEquals([1], $subset->getSubset(1));
    }

    public function testSetOfOneEqualsToTargetRepeated()
    {
        $subset = SubsetSum::createWithRepetition([1], 100, [
            'comparable' => new PreferLowerSumComparable()
        ]);

        $this->assertEquals([1, 1], $subset->getSubset(2));
    }

    public function testSetOneItemEqualsToTarget()
    {
        $subset = SubsetSum::createWithRepetition([2, 3], 100, [
            'comparable' => new PreferLowerSumComparable()
        ]);

        $this->assertEquals([3], $subset->getSubset(3));
    }

    public function testSetNoneEqualsTargetPickClosestPositive()
    {
        $subset = SubsetSum::createWithRepetition([4, 5, 7], 100, [
            'comparable' => new PreferLowerSumComparable()
        ]);

        $this->assertEquals([5], $subset->getSubset(6));
    }

    public function testSetCombinationEquals()
    {
        $subset = SubsetSum::createWithRepetition([1, 2, 4, 5, 7], 100, [
            'comparable' => new PreferLowerSumComparable()
        ]);

        $this->assertEquals([2, 1], $subset->getSubset(3));
    }

    public function testSetTwoSubsetsEqualsPickFirstInSet()
    {
        $subset = SubsetSum::createWithRepetition([2, 4, 5, 7], 100, [
            'comparable' => new PreferLowerSumComparable()
        ]);

        $this->assertEquals([7, 2], $subset->getSubset(9));
    }

    public function testSetStepSize10()
    {
        $subset = SubsetSum::createWithRepetition([30, 40], 100, [
            'comparable' => new PreferLowerSumComparable()
        ]);

        $this->assertEquals([40, 30, 30], $subset->getSubset(100));
    }

    public function testSetStepSize10NotEquesl()
    {
        $subset = SubsetSum::createWithRepetition([50, 70], 160, [
            'comparable' => new PreferLowerSumComparable(),
            'step' => 10
        ]);

        $this->assertEquals([50, 50, 50], $subset->getSubset(160));
    }
}