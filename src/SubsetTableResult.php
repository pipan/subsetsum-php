<?php


namespace SubsetSum;


interface SubsetTableResult extends SubsetResult
{
    public function getSubsetForTarget($target);
}