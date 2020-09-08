<?php


namespace SubsetSum;


class TargetsTable implements Subset
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