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
            $inputs['repetition']['default']
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

        $this->assertEquals($subset, $subsetTable->getSubset($target));
    }

    public function testNegativeTargetThrowsException()
    {
        $this->expectException(\InvalidArgumentException::class);

        $subsetTable = SubsetSum::builder()
            ->withSet([1])
            ->withTarget(-1)
            ->buildWithRepetition();

        $subsetTable->getSubset(-1);
    }

    public function testSetStepSize10()
    {
        $subset = SubsetSum::createWithRepetition([30, 40], 100, [
            'comparable' => new PreferLowerSumComparable()
        ]);

        $this->assertEquals([40, 30, 30], $subset->getSubset(100));
    }

    public function testSetStepSize10NotEquesl()
    {
        $subset = SubsetSum::createWithRepetition([50, 70], 160, [
            'comparable' => new PreferLowerSumComparable(),
            'step' => 10
        ]);

        $this->assertEquals([50, 50, 50], $subset->getSubset(160));
    }
}