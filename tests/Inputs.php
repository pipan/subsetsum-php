<?php

namespace Tests;

class Inputs
{
    public static function getCorrectInputs()
    {
        return [
            'no_repetition' => [
                'default' => [
                    'setSizeOfOne_exactMatch' => [[1], 1, [1]],
                    'setSizeOfTwo_exactMatch' => [[1, 3], 3, [3]],
                    'setSizeOfFive_exactMatchCombination' => [[1, 2, 5, 7, 11], 20, [11, 7, 2]],
                    'twoSubsetsMatch_pickLatterInSet' => [[2, 4, 5, 7], 9, [7, 2]],
                    'setUnsorted_exactMatchCombination' => [[5, 1, 3], 4, [3, 1]],
                    'setUnsorted_exactMatchCombinationReversedOrder' => [[5, 3, 1], 4, [1, 3]],
                    'setSizeOfOne_targetZero' => [[1, 2, 3], 0, []]
                ],
                'closest' => [
                    'pickCloser_nineIsCloserToEight' => [[5, 9], 8, [9]],
                    'pickCloser_fiveIsCloserToSix' => [[5, 9], 6, [5]],
                    'pickCloser_sameDistance' => [[5, 9], 7, [9]],
                ],
                'greater' => [
                    'pickGreater_nineIsCloserToEight' => [[5, 9], 8, [9]],
                    'pickGreater_fiveIsCloserToSix' => [[5, 9], 6, [9]],
                    'pickGreater_sameDistance' => [[5, 9], 7, [9]],
                ],
                'lower' => [
                    'pickLower_nineIsCloserToEight' => [[5, 9], 8, [5]],
                    'pickLower_fiveIsCloserToSix' => [[5, 9], 6, [5]],
                    'pickLower_sameDistance' => [[5, 9], 7, [5]],
                ]
            ],
            'repetition' => [
                'default' => [
                    'setSizeOfOne_exactMatchRepetition' => [[1], 3, [1, 1, 1]],
                ],
                'closest' => [],
                'greater' => [],
                'lower' => []
            ]
        ];
    }

    public static function getInvalidArgumentInputs()
    {
        return [
            'no_repetition' => [
                'negativeTarget' => [[1], -1],
                'negativeSetValue' => [[1, -3], 1]
            ],
            'repetition' => []
        ];
    }

    public static function getExceptionInputs()
    {
        return [
            'no_repetition' => [
                'emptySet' => [[], 10, []]
            ],
            'repetition' => []
        ];
    }
}