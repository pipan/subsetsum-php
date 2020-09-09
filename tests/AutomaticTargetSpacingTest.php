<?php


namespace Tests;


use PHPUnit\Framework\TestCase;
use SubsetSum\SubsetSum;

class AutomaticTargetSpacingTest extends TestCase
{
    public function getCorrectInputs()
    {
        return [
            'targetGreaterThenBiggestSetValue' => [[5, 10], 16, [10, 5]]
        ];
    }

    /**
     * @dataProvider getCorrectInputs
     */
    public function testCorrectTargetSpacing($set, $target, $subset)
    {
        $subsetTable = SubsetSum::builder()
            ->withSet($set)
            ->withTarget($target)
            ->buildWithRepetition();

        $this->assertEquals($subset, $subsetTable->getSubset($target));
    }
}