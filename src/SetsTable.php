<?php


namespace SubsetSum;

use Exception;
use InvalidArgumentException;

class SetsTable implements SubsetTableResult
{
    private $nodes;
    private $maxTarget;

    public function __construct($nodes)
    {
        $this->nodes = $nodes;
        $countSets = count($this->nodes);
        if ($countSets === 0) {
            throw new Exception("Cannot create SetsTable with empty nodes data");
        }
        $this->maxTarget = $this->getLastKey($this->nodes[$countSets - 1]);
    }

    private function getLastKey($array)
    {
        end($array);
        return key($array);
    }

    public static function create($set, $targetSet, $comparable)
    {
        foreach ($set as $value) {
            if ($value <= 0) {
                throw new InvalidArgumentException("Set cannot containt value less then 1");
            }
        }
        $nodes = [];
        for ($i = 0; $i < count($set); $i++) {
            $setValue = $set[$i];
            foreach ($targetSet as $targetValue) {
                if ($targetValue === 0) {
                    $nodes[$i][$targetValue] = new TargetNode(0, null, []);
                    continue;
                }
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

    private function get($target)
    {
        $countSets = count($this->nodes);
        if (!isset($this->nodes[$countSets - 1][$target])) {
            return null;
        }
        return $this->nodes[$countSets - 1][$target];
    }

    public function getSubsetForTarget($target)
    {
        $node = $this->get($target);
        if ($node === null) {
            throw new InvalidArgumentException("Target '$target' is not found in sets table");
        }
        return $node->getSubset();
    }

    public function getSubset()
    {
        try {
            return $this->getSubsetForTarget($this->maxTarget);
        } catch (InvalidArgumentException $ex) {
            throw new Exception("Cannot create subset", 0, $ex);
        }
    }
}