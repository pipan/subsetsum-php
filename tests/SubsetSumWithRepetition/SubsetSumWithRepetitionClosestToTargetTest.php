<?php


namespace Tests\SubsetSumWithRepetition;


use PHPUnit\Framework\TestCase;
use SubsetSum\SubsetSum;
use SubsetSum\SubsetSumWithRepetition;

class SubsetSumWithRepetitionClosestToTargetTest extends TestCase
{
    public function testSetNotEqualsNineIsCloserToEight()
    {
        $subset = SubsetSum::createWithRepetition([5, 9], 100);

        $this->assertEquals([9], $subset->getSubset(8));
    }

    public function testSetNotEqualsFiveIsCloserToSix()
    {
        $subset = SubsetSum::createWithRepetition([5, 9], 100);

        $this->assertEquals([5], $subset->getSubset(6));
    }

    public function testSetNotEqualsBothSameDistancePickLatter()
    {
        $subset = SubsetSum::createWithRepetition([5, 9], 100);

        $this->assertEquals([9], $subset->getSubset(7));
    }
}