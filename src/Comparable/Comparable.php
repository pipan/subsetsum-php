<?php


namespace SubsetSum\Comparable;


use SubsetSum\TargetNode;

interface Comparable
{
    public function compare(TargetNode $a, TargetNode $b);
}