<?php


namespace Tests\SubsetSum;


use PHPUnit\Framework\TestCase;
use SubsetSum\SubsetSum;

class SubsetSumClosestToTargetTest extends TestCase
{
    public function testSetSizeOneContainsExactValue()
    {
        $subset = SubsetSum::create([1], 1);

        $this->assertEquals([1], $subset->getSubset(1));
    }

    public function testSetSizeTwoContainsExactValue()
    {
        $subset = SubsetSum::create([1, 3], 100);

        $this->assertEquals([3], $subset->getSubset(3));
    }

    public function testSetSizeFiveCombineTwoForTargetValue()
    {
        $subset = SubsetSum::create([1, 2, 5, 7, 11], 100);

        $this->assertEquals([11, 7, 2], $subset->getSubset(20));
    }

    public function testSetSizeFiveNotExactMatchPickClosest()
    {
        $subset = SubsetSum::create([1, 2, 5, 7, 11], 100);

        $this->assertEquals([5], $subset->getSubset(4));
    }
}