<?php


namespace SubsetSum\Comparable;


use SubsetSum\TargetNode;

class ComparableFunction implements Comparable
{
    private $fn;

    public function __construct($fn)
    {
        $this->fn = $fn;
    }

    public function compare(TargetNode $a, TargetNode $b)
    {
        return call_user_func_array($this->fn, [$a, $b]);
    }
}