<?php


namespace Tests\SubsetSum;


use PHPUnit\Framework\TestCase;
use SubsetSum\Comparable\ClosestLowerThenTargetComparable;
use SubsetSum\SubsetSum;

class SubsetSumLowerThenTargetTest extends TestCase
{
    public function testSetSizeOneContainsExactValue()
    {
        $subset = SubsetSum::create([1], 1, [
            'comparable' => new ClosestLowerThenTargetComparable()
        ]);

        $this->assertEquals([1], $subset->getSubset(1));
    }

    public function testSetSizeTwoContainsExactValue()
    {
        $subset = SubsetSum::create([1, 3], 100, [
            'comparable' => new ClosestLowerThenTargetComparable()
        ]);

        $this->assertEquals([3], $subset->getSubset(3));
    }

    public function testSetSizeFiveCombineTwoForTargetValue()
    {
        $subset = SubsetSum::create([1, 2, 5, 7, 11], 100, [
            'comparable' => new ClosestLowerThenTargetComparable()
        ]);

        $this->assertEquals([11, 7, 2], $subset->getSubset(20));
    }

    public function testSetSizeFiveNotExactMatchPickLower()
    {
        $subset = SubsetSum::create([1, 2, 5, 7, 13], 100, [
            'comparable' => new ClosestLowerThenTargetComparable()
        ]);

        $this->assertEquals([7, 2, 1], $subset->getSubset(11));
    }

    public function testSetSizeFiveNonLowerPickTheSmalles()
    {
        $subset = SubsetSum::create([13, 17, 22], 100, [
            'comparable' => new ClosestLowerThenTargetComparable()
        ]);

        $this->assertEquals([13], $subset->getSubset(8));
    }
}