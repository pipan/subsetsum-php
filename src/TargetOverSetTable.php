<?php


namespace SubsetSum;


class TargetOverSetTable implements Subset
{
    private $nodes;

    public function __construct($nodes)
    {
        $this->nodes = $nodes;
    }

    public static function create($set, $targetSet, $comparable)
    {
        $nodes = [];
        foreach ($targetSet as $targetValue) {
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
        return new TargetOverSetTable($nodes);
    }

    public function get($target): ?TargetNode
    {
        if (!isset($this->nodes[$target])) {
            return null;
        }
        return $this->nodes[$target];
    }

    public function getSubset($target): array
    {
        $node = $this->get($target);
        if ($node === null) {
            return [];
        }
        return $node->getSubset();
    }
}