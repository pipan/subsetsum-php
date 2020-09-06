<?php


namespace SubsetSum;


interface Subset
{
    public function getSubset($target): array;
    public function get($target): ?TargetNode;
}