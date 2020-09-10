<?php


namespace Tests;

use PHPUnit\Framework\TestCase;
use SubsetSum\SubsetSum;

class ExactMatchTest extends TestCase
{
    public function testCorrectExactMatch()
    {
        $subsetTable = SubsetSum::builder()
            ->withSet([30, 40])
            ->withTarget(100)
            ->onlyExactSum()
            ->buildWithRepetition();

        $this->assertEquals([40, 30, 30], $subsetTable->getSubset());
    }

    public function testCorrectNotExactMatch()
    {
        $subsetTable = SubsetSum::builder()
            ->withSet([30, 40])
            ->withTarget(35)
            ->onlyExactSum()
            ->buildWithRepetition();

        $this->assertEquals([], $subsetTable->getSubset());
    }
}