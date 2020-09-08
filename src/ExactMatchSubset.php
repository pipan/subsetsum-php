<?php

namespace SubsetSum;

class ExactMatchSubset implements Subset
{
    private $table;

    public function __construct(Subset $table)
    {
        $this->table = $table;
    }

    public function get($target): ?TargetNode
    {
        $subset = $this->table->get($target);
        if ($subset === null) {
            return null;
        }
        if ($subset->getValue() !== 0) {
            return null;
        }
        return $subset;
    }

    public function getSubset($target): array
    {
        $subset = $this->get($target);
        if ($subset === null) {
            return [];
        }
        return $subset->getSubset();
    }
}