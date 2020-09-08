<?php


namespace Tests\SubsetSum;


use PHPUnit\Framework\TestCase;
use SubsetSum\SubsetSum;

class SubsetSumClosestToTargetTest extends TestCase
{
    public function getCorrectInput() {
        return [
            'setSizeOfOne_exactMatch' => [[1], 1, [1]],
            'setSizeOfTwo_exactMatch' => [[1, 3], 3, [3]],
            'setSizeOfFive_exactMatchCombination' => [[1, 2, 5, 7, 11], 20, [11, 7, 2]],
            'setSizeOfFive_notExactMatch_pickClosest' => [[1, 2, 5, 7, 11], 4, [5]],
            'setUnsorted_exactMatchCombination' => [[5, 1, 3], 4, [3, 1]],
            'setUnsorted_exactMatchCombinationReversedOrder' => [[5, 3, 1], 4, [1, 3]],
            'setSizeOfOne_targetZero' => [[1, 2, 3], 0, []],
            'emptySet' => [[], 10, []]
        ];
    }

    /**
     * @dataProvider getCorrectInput
     */
    public function testCorrectInput($set, $target, $subset)
    {
        $subsetTable = SubsetSum::builder()
            ->withSet($set)
            ->withTarget($target)
            ->build();

        $this->assertEquals($subset, $subsetTable->getSubset($target));
    }

    public function testNegativeTargetThrowsException()
    {
        $this->expectException(\InvalidArgumentException::class);

        $subsetTable = SubsetSum::builder()
            ->withSet([1])
            ->withTarget(-1)
            ->build();

        $subsetTable->getSubset(-1);
    }
}