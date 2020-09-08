<?php


namespace Tests\SubsetSumWithRepetition;


use PHPUnit\Framework\TestCase;
use SubsetSum\Comparable\PreferGreaterSumComparable;
use SubsetSum\SubsetSum;
use SubsetSum\SubsetSumWithRepetition;

class SubsetSumWithRepetitionGreaterThenTargetTest extends TestCase
{
    public function testSetOfOneEqualsToTarget()
    {
        $subset = SubsetSum::createWithRepetition([1], 100, [
            'comparable' => new PreferGreaterSumComparable()
        ]);

        $this->assertEquals([1], $subset->getSubset(1));
    }

    public function testSetOfOneEqualsToTargetRepeated()
    {
        $subset = SubsetSum::createWithRepetition([1], 100, [
            'comparable' => new PreferGreaterSumComparable()
        ]);

        $this->assertEquals([1, 1], $subset->getSubset(2));
    }

    public function testSetOneItemEqualsToTarget()
    {
        $subset = SubsetSum::createWithRepetition([2, 3], 100, [
            'comparable' => new PreferGreaterSumComparable()
        ]);

        $this->assertEquals([3], $subset->getSubset(3));
    }

    public function testSetNoneEqualsTargetPickClosestPositive()
    {
        $subset = SubsetSum::createWithRepetition([2, 4, 5, 7], 100, [
            'comparable' => new PreferGreaterSumComparable()
        ]);

        $this->assertEquals([4], $subset->getSubset(3));
    }

    public function testSetCombinationEquals()
    {
        $subset = SubsetSum::createWithRepetition([1, 2, 4, 5, 7], 100, [
            'comparable' => new PreferGreaterSumComparable()
        ]);

        $this->assertEquals([2, 1], $subset->getSubset(3));
    }

    public function testSetTwoSubsetsEqualsPickFirstInSet()
    {
        $subset = SubsetSum::createWithRepetition([2, 4, 5, 7], 100, [
            'comparable' => new PreferGreaterSumComparable()
        ]);

        $this->assertEquals([7, 2], $subset->getSubset(9));
    }

    public function testSetStepSize10()
    {
        $subset = SubsetSum::createWithRepetition([30, 40], 100, [
            'comparable' => new PreferGreaterSumComparable(),
            'step' => 10
        ]);

        $this->assertEquals([40, 30, 30], $subset->getSubset(100));
    }

    public function testSetStepSize10NotEquesl()
    {
        $subset = SubsetSum::createWithRepetition([50, 70], 300, [
            'comparable' => new PreferGreaterSumComparable(),
            'step' => 10
        ]);

        $this->assertEquals([70, 50, 50], $subset->getSubset(160));
    }
}