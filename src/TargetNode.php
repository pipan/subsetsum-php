<?php


namespace SubsetSum;


class TargetNode
{
    private $previous;
    private $value;
    private $subset;

    public function __construct($value, $previous, $subset)
    {
        $this->value = $value;
        $this->subset = $subset;
        $this->previous = $previous;
    }

    public function getValue()
    {
        return $this->value;
    }

    public function getSubset()
    {
        return $this->subset;
    }

    public function getPrevious()
    {
        return $this->previous;
    }

    public function hasPrevious()
    {
        return $this->previous !== null;
    }
}