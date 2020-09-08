<?php


namespace Tests\SubsetSum;


use PHPUnit\Framework\TestCase;
use SubsetSum\Comparable\PreferGreaterSumComparable;
use SubsetSum\SubsetSum;

class SubsetSumGreaterThenTargetTest extends TestCase
{
    public function testSetSizeOneContainsExactValue()
    {
        $subset = SubsetSum::create([1], 1, [
            'comparable' => new PreferGreaterSumComparable()
        ]);

        $this->assertEquals([1], $subset->getSubset(1));
    }

    public function testSetSizeTwoContainsExactValue()
    {
        $subset = SubsetSum::create([1, 3], 100, [
            'comparable' => new PreferGreaterSumComparable()
        ]);

        $this->assertEquals([3], $subset->getSubset(3));
    }

    public function testSetSizeFiveCombineTwoForTargetValue()
    {
        $subset = SubsetSum::create([1, 2, 5, 7, 11], 100, [
            'comparable' => new PreferGreaterSumComparable()
        ]);

        $this->assertEquals([11, 7, 2], $subset->getSubset(20));
    }

    public function testSetSizeFiveNotExactMatchPickGreater()
    {
        $subset = SubsetSum::create([1, 2, 5, 7, 13], 100, [
            'comparable' => new PreferGreaterSumComparable()
        ]);

        $this->assertEquals([7, 5], $subset->getSubset(11));
    }

    public function testSetSizeFiveNonGreaterPickTheBiggest()
    {
        $subset = SubsetSum::create([1, 2, 5, 7, 13], 100, [
            'comparable' => new PreferGreaterSumComparable()
        ]);

        $this->assertEquals([13, 7, 5, 2, 1], $subset->getSubset(50));
    }
}