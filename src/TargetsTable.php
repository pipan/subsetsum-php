<?php


namespace SubsetSum;

use Exception;
use InvalidArgumentException;

class TargetsTable implements SubsetTableResult
{
    private $nodes;
    private $maxTarget;

    public function __construct($nodes)
    {
        $this->nodes = $nodes;

        $count = count($this->nodes);
        if ($count === 0) {
            throw new Exception("Cannot create TargetsTable with empty nodes data");
        }
        $this->maxTarget = array_key_last($this->nodes);
    }

    public static function create($set, $targetSet, $comparable)
    {
        foreach ($set as $value) {
            if ($value <= 0) {
                throw new \InvalidArgumentException("Set cannot containt value less then 1");
            }
        }
        $nodes = [];
        foreach ($targetSet as $targetValue) {
            if ($targetValue === 0) {
                $nodes[$targetValue] = new TargetNode(0, null, []);
                continue;
            }
            foreach ($set as $setValue) {
                $node = new TargetNode($targetValue - $setValue, null, [$setValue]);
                $reminder = $node->getValue();
                if (isset($nodes[$reminder])) {
                    $previousNode = $nodes[$reminder];
                    $subset = array_merge([$setValue], $previousNode->getSubset());
                    $nodeWithPrevious = new TargetNode($previousNode->getValue(), $previousNode, $subset);
                    $node = $comparable->compare($node, $nodeWithPrevious);
                }
                if (isset($nodes[$targetValue])) {
                    $node = $comparable->compare($node, $nodes[$targetValue]);
                }
                $nodes[$targetValue] = $node;
            }
        }
        return new TargetsTable($nodes);
    }

    private function get($target): ?TargetNode
    {
        if (!isset($this->nodes[$target])) {
            return null;
        }
        return $this->nodes[$target];
    }

    public function getSubsetForTarget($target): array
    {
        $node = $this->get($target);
        if ($node === null) {
            throw new InvalidArgumentException("Target '$target' is not found in targets table");
        }
        return $node->getSubset();
    }

    public function getSubset(): array
    {
        try {
            return $this->getSubsetForTarget($this->maxTarget);
        } catch (InvalidArgumentException $ex) {
            throw new Exception("Cannot create subset", 0, $ex);
        }
    }
}