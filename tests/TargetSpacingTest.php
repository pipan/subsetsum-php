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

        $this->assertEquals([40, 30, 30], $subsetTable->getSubset());
    }

    public function testTargetNotMultiplicationOfSpacing()
    {
        $subsetTable = SubsetSum::builder()
            ->withSet([30, 40])
            ->withTargetSpaced(101, 10)
            ->buildWithRepetition();

        $this->assertEquals([40, 30, 30], $subsetTable->getSubset());
    }

    public function testTargetLessThenSpacing()
    {
        $subsetTable = SubsetSum::builder()
            ->withSet([30, 40])
            ->withTargetSpaced(101, 999)
            ->buildWithRepetition();

        $this->assertEquals([40], $subsetTable->getSubset());
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