<?php


namespace Tests;


use PHPUnit\Framework\TestCase;
use SubsetSum\SubsetSum;

class TargetSpacingTest extends TestCase
{
    public function testCorrectTargetSpacing()
    {
        $subsetTable = SubsetSum::builder()
            ->withSet([30, 40])
            ->withTargetSpaced(100, 10)
            ->buildWithRepetition();

        $this->assertEquals([40, 30, 30], $subsetTable->getSubset(100));
    }

    public function testSpacingWithUnreachableTarget()
    {
        $subsetTable = SubsetSum::builder()
            ->withSet([30, 40])
            ->withTargetSpaced(101, 10)
            ->buildWithRepetition();

        $this->assertEquals([], $subsetTable->getSubset(101));
    }

    public function testNegativeSpacingInvalidArgument()
    {
        $this->expectException(\InvalidArgumentException::class);
        $subsetTable = SubsetSum::builder()
            ->withSet([30, 40])
            ->withTargetSpaced(10, -10)
            ->buildWithRepetition();
    }

    public function testZeroSpacingInvalidArgument()
    {
        $this->expectException(\InvalidArgumentException::class);
        $subsetTable = SubsetSum::builder()
            ->withSet([30, 40])
            ->withTargetSpaced(10, 0)
            ->buildWithRepetition();
    }
}