<?php


namespace Tests\SubsetSumWithRepetition;


use PHPUnit\Framework\TestCase;
use SubsetSum\Comparable\PreferLowerSumComparable;
use SubsetSum\SubsetSum;
use Tests\Inputs;

class SubsetSumWithRepetitionLowerThenTargetTest extends TestCase
{
    public function getCorrectInput() {
        $inputs = Inputs::getCorrectInputs();
        return array_merge(
            $inputs['no_repetition']['default'],
            $inputs['no_repetition']['lower'],
            $inputs['repetition']['default'],
            $inputs['repetition']['lower']
        );
    }

    /**
     * @dataProvider getCorrectInput
     */
    public function testCorrectInput($set, $target, $subset)
    {
        $subsetTable = SubsetSum::builder()
            ->withSet($set)
            ->withTarget($target)
            ->withComparable(new PreferLowerSumComparable())
            ->buildWithRepetition();

        $this->assertEquals($subset, $subsetTable->getSubset());
    }

    public function getInvalidArgumentInput() {
        $inputs = Inputs::getInvalidArgumentInputs();
        return $inputs['no_repetition'];
    }

    /**
     * @dataProvider getInvalidArgumentInput
     */
    public function testInvalidArgumentException($set, $target)
    {
        $this->expectException(\InvalidArgumentException::class);

        $subsetTable = SubsetSum::builder()
            ->withSet($set)
            ->withTarget($target)
            ->build();
    }
}