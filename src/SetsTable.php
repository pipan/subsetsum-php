<?php


namespace SubsetSum;


class SetsTable implements Subset
{
    private $nodes;

    public function __construct($nodes)
    {
        $this->nodes = $nodes;
    }

    public static function create($set, $targetSet, $comparable)
    {
        $nodes = [];
        for ($i = 0; $i < count($set); $i++) {
            $setValue = $set[$i];
            foreach ($targetSet as $targetValue) {
                $node = new TargetNode($targetValue - $setValue, null, [$setValue]);
                if (isset($nodes[$i - 1][$node->getValue()])) {
                    $previousNode = $nodes[$i - 1][$node->getValue()];
                    $subset = array_merge([$setValue], $previousNode->getSubset());
                    $nodeWithPreviousNode = new TargetNode($previousNode->getValue(), $previousNode, $subset);
                    $node = $comparable->compare($node, $nodeWithPreviousNode);
                }

                if (isset($nodes[$i - 1][$targetValue])) {
                    $previousNode = $nodes[$i - 1][$targetValue];
                    $node = $comparable->compare($node, $previousNode);
                }

                $nodes[$i][$targetValue] = $node;
            }
        }
        return new SetsTable($nodes);
    }

    public function get($target): ?TargetNode
    {
        $countSets = count($this->nodes);
        if (!isset($this->nodes[$countSets - 1])) {
            return null;
        }
        if (!isset($this->nodes[$countSets - 1][$target])) {
            return null;
        }
        return $this->nodes[$countSets - 1][$target];
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