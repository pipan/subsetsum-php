# Subset Sum

[![Build Status](https://travis-ci.com/pipan/subsetsum-php.svg?branch=master)](https://travis-ci.com/pipan/subsetsum-php)

## Installation

__Via composer__

`require lmn/subsetsum`

## API

```php
<?php
$subsetTable = SubsetSum::builder()
    ->withSet([1, 2, 5])
    ->withTarget(8)
    ->build();

$subset = $subsetTable->getSubset(8);
?>
```

### Set Of Values

```php
<?php
$subsetTable = SubsetSum::builder()
    ->withSet([1, 2, 5])
    ...
    ->build();
?>
```

### Target

### Create Subset Sum

### Create Subset Sum With Repetition

### Calculate Result Subset

```php
<?php
$subsetTable = SubsetSum::builder()
    ...
    ->build();

$subset = $subsetTable->getSubset(100)
?>
```

### Custom Compare Function

```php
<?php
$subsetTable = SubsetSum::builder()
    ...
    ->withComperable(new CustomComperable())
    ->build();
?>
```

```php
<?php
$subsetTable = SubsetSum::builder()
    ...
    ->withComperableFunction(function ($a, $b) {})
    ->build();
?>
```

## Algorithm

To compute a subset sum in a polynomial time you have to use dynamic programming. This method will find subset in `O(n * m)` where `n` is number of items in source set and `m` in number of target increments.

Let's assume you want to find subset equal to `100` and you can use only values in set `setOfValues = {10, 20, 50, 70}`. You would devide the target to smaller pecies, Actually, you would want to use `the greatest common diviser` of a set of values to create those smaller target pieces. In this example, the GCD would be `10` and our target pieces would look like this `setOfTargets = {0, 10, 20, 30, 40 50, 60, 70, 80, 90, 100}`. So our `n` would be equal to `count(setOfValues) == 4` and our `m` would equal to `count(setOfTargets) == 11`.

### For Subset Sum

To calculate subset sum without repetition, we have to create a table which row represent set item and columns are target pieces. We will iterate from left to right and from top to bottom. In other words, we will iterate every row and for every row we iterate every column.

> Rows and columns have to be sorted in ascending order

|        | 0 | 10 | 20 | 30 | 40 | 50 | 60 | 70 | 80 | 90 | 100 |
|:------:|:-:|:--:|:--:|:--:|:--:|:--:|:--:|:--:|:--:|:--:|:---:|
| __0__  | 0 | 10 | 20 | 30 | 40 | 50 | 60 | 70 | 80 | 90 | 100 |
| __10__ | 0 | 0  | 10 | 20 | 30 | 40 | 50 | 60 | 70 | 80 | 90  |
| __20__ | 0 | 0  | 0  | 0  | 10 | 20 | 30 | 40 | 50 | 60 | 70  |
| __50__ | 0 | 0  | 0  | 0  | 10 | 0  | 0  | 0  | 10 | 20 | 30  |
| __70__ | 0 | 0  | 0  | 0  | 10 | 0  | 0  | 0  | 0  | 0  | 0   |
> Example of a subset sum finnished table

Table cell represents how close we can get to target number with current rows filled. So if the cell value is `0` it means we can create subset that will produce sum equal to column value. If the cell value is `10` that means we can produce a subset, which subset is 10 less then column value. To fill a cell value we will use this algorithm:

* try to subtract column value and row value. Let's call it `diff`
* if `diff` is greated then 0 take the value in cell in row above and in column with value `diff`. Let's call this value `diff-with-previous`.
* last value is cell in current column and row above. Let's call this value `skip-current-row`

Compare all these three values (`diff`, `diff-with-previous` and `skip-current-row`) pick the value, that is the best for. In this case we will pick a value that's absolute value is the lowest.

|        | 0 | 10                   | 20 | 30                 | 40 | 50 | 60 | 70 | 80 | 90 | 100 |
|:------:|:-:|:--------------------:|:--:|:------------------:|:--:|:--:|:--:|:--:|:--:|:--:|:---:|
| __0__  | 0 | 10                   | 20 | 30                 | 40 | 50 | 60 | 70 | 80 | 90 | 100 |
| __10__ | 0 | `diff-with-previous` | 10 | `skip-current-row` | 30 | 40 | 50 | 60 | 70 | 80 | 90  |
| __20__ | 0 | 0                    | 0  | `diff`             |    |    |    |    |    |    |     |
| __50__ |   |                      |    |                    |    |    |    |    |    |    |     |
| __70__ |   |                      |    |                    |    |    |    |    |    |    |     |

|        | 0 | 10  | 20 | 30   | 40 | 50 | 60 | 70 | 80 | 90 | 100 |
|:------:|:-:|:---:|:--:|:----:|:--:|:--:|:--:|:--:|:--:|:--:|:---:|
| __0__  | 0 | 10  | 20 | 30   | 40 | 50 | 60 | 70 | 80 | 90 | 100 |
| __10__ | 0 | `0` | 10 | `20` | 30 | 40 | 50 | 60 | 70 | 80 | 90  |
| __20__ | 0 | 0   | 0  | `10` |    |    |    |    |    |    |     |
| __50__ |   |     |    |      |    |    |    |    |    |    |     |
| __70__ |   |     |    |      |    |    |    |    |    |    |     |

|        | 0 | 10  | 20 | 30  | 40 | 50 | 60 | 70 | 80 | 90 | 100 |
|:------:|:-:|:---:|:--:|:---:|:--:|:--:|:--:|:--:|:--:|:--:|:---:|
| __0__  | 0 | 10  | 20 | 30  | 40 | 50 | 60 | 70 | 80 | 90 | 100 |
| __10__ | 0 | `0` | 10 | 20  | 30 | 40 | 50 | 60 | 70 | 80 | 90  |
| __20__ | 0 | 0   | 0  | `0` |    |    |    |    |    |    |     |
| __50__ |   |     |    |     |    |    |    |    |    |    |     |
| __70__ |   |     |    |     |    |    |    |    |    |    |     |

### For Subset Sum With Repetition

|         | 0    | 10  | 20  | 50  | 70  | best |
|:-------:|:----:|:---:|:---:|:---:|:---:|:----:|
| __0__   | 0    | -10 | -20 | -50 | -70 | 0    |
| __10__  | -10  | 0   | -10 | -40 | -60 | 10   |
| __20__  | -20  | 0   | 0   | -30 | -50 | 20   |
| __30__  | -30  | 0   | 0   | -20 | -40 | 20   |
| __40__  | -40  | 0   | 0   | -10 | -30 | 20   |
| __50__  | -50  | 0   | 0   | 0   | -20 | 50   |
| __60__  | -60  | 0   | 0   | 0   | -10 | 50   |
| __70__  | -70  | 0   | 0   | 0   | 0   | 70   |
| __80__  | -80  | 0   | 0   | 0   | 0   | 70   |
| __90__  | -90  | 0   | 0   | 0   | 0   | 70   |
| __100__ | -100 | 0   | 0   | 0   | 0   | 70   |