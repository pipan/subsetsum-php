<?php

namespace SubsetSum;

class ExactMatchSubset implements SubsetTableResult
{
    private $table;
    private $defaultTarget;

    public function __construct(SubsetTableResult $table, $defaultTarget)
    {
        $this->table = $table;
        $this->defaultTarget = $defaultTarget;
    }

    public function getSubsetForTarget($target): array
    {
        $subset = $this->table->getSubsetForTarget($target);
        $sum = 0;
        foreach ($subset as $value) {
            $sum += $value;
        }

        if ($sum !== $target) {
            return [];
        }
        
        return $subset;
    }

    public function getSubset(): array
    {
        return $this->getSubsetForTarget($this->defaultTarget);
    }
}