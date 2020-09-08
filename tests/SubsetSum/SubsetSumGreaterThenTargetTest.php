<?php


namespace Tests\SubsetSum;


use PHPUnit\Framework\TestCase;
use SubsetSum\Comparable\PreferGreaterSumComparable;
use SubsetSum\SubsetSum;
use Tests\Inputs;

class SubsetSumGreaterThenTargetTest extends TestCase
{
    public function getCorrectInput() {
        $inputs = Inputs::getCorrectInputs();
        return array_merge($inputs['no_repetition']['default'], $inputs['no_repetition']['greater']);
    }

    /**
     * @dataProvider getCorrectInput
     */
    public function testCorrectInput($set, $target, $subset)
    {
        $subsetTable = SubsetSum::builder()
            ->withSet($set)
            ->withTarget($target)
            ->withComparable(new PreferGreaterSumComparable())
            ->build();

        $this->assertEquals($subset, $subsetTable->getSubset($target));
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

        $subsetTable->getSubset($target);
    }
}