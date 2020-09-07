# Subset Sum

[![Build Status](https://travis-ci.com/pipan/subsetsum-php.svg?branch=master)](https://travis-ci.com/pipan/subsetsum-php)

## Installation

__Via composer__

`require lmn/subsetsum`

## API

We recommend using `SubsetSumBuilder` for generating your subset sum tables. To create a builder just call `SubsetSum::builder()` static method.

```php
<?php
$subsetTable = SubsetSum::builder()
    ->withSet([1, 2, 5])
    ->withTarget(8)
    ->build();

$subset = $subsetTable->getSubset(8);
?>
```

> You can also use other static methods of SubsetSum class, if you prefer to create your subset tables other way `SubsetSum::create` and `SubsetSum::createWithRepetition`.

### Set Of Values

Provide a set of possible values used in subset by calling `withSet` method of a builder.

```php
<?php
$subsetTable = SubsetSum::builder()
    ->withSet([1, 2, 5])
    ...
?>
```

### Target

To define the maximu target af a table call `withTarget` method with first argument of a maximum target value and second argument of taraget spacing.

```php
<?php
$subsetTable = SubsetSum::builder()
    ->withTarget(800, 100)
    ...
?>
```

> This example will create targets spaced out by 100 `{0, 100, 200, 300, 400, 500, 600, 700, 800}`

You can also specify a custom target set unevenly spaced out by calling `withTargetSet` method of a builder.

```php
<?php
$subsetTable = SubsetSum::builder()
    ->withTargetSet([1, 2, 3, 5, 8, 13, 21, 34])
    ...
?>
```

### Create Subset Sum

To create a Subset Sum table call `build` method of a builder;

```php
<?php
$subsetTable = SubsetSum::builder()
    ...
    ->build();
?>
```

### Create Subset Sum Table With Repetition

To create a Subset Sum With Repetition table call `buildWithRepetition` method of a builder;

```php
<?php
$subsetTable = SubsetSum::builder()
    ...
    ->buildWithRepetition();
?>
```

### Calculate Result Subset

To calculate a subset from table call `getSubset` method of a subsetTable. The argument is a target value you vant your subset to have. If You request a bigger target value, then the table was build for, you will receive empty array.

```php
<?php
$subsetTable = SubsetSum::builder()->...->build();

$subset = $subsetTable->getSubset(100)
?>
```

### Custom Compare Function

Sometimes you may want to change the algorithm that decides what is the best cell value. TO change this decision making function call `withComperable` method of a builder with an argument of a class that implements `Comeparable` interface.

> You can also use `withComparableFunction` method of a builder with an callback argument.

```php
<?php
$subsetTable = SubsetSum::builder()
    ->withComperable(new CustomComperable())
    ...
?>
```

## Algorithm

To compute a subset sum in a polynomial time you have to use dynamic programming. This method will find subset in `O(n * m)` where `n` is number of items in source set and `m` is number of target increments.

Let's assume you want to find a subset equal to `100` and you can use only values in set `setOfValues = {10, 20, 50, 70}`. You would divide the target to smaller pecies, Actually, you would want to use `the greatest common diviser` of a set of values to create those smaller target pieces. In this example, the GCD would be `10` and our target pieces would look like this `setOfTargets = {0, 10, 20, 30, 40 50, 60, 70, 80, 90, 100}`. So our `n` would be equal to `count(setOfValues) == 4` and our `m` would equal to `count(setOfTargets) == 11`.

> In this case it's faster to compute all permutations of values set (4 * 3 * 2 * 1 = 24) in comparison to our approach (11 * 4 = 44). If the set of values gets larger, we will see the advantage of our approach. Let's assume we have 20 items in the set. For all permutations, we will get (20! = 2.432902e+18). Now let's take a look at our approach and let's assume, we want to compute target number of 1000000 and the target set will contain every number until 1000000. So our approach will take 20 * 1000000 = 2*e+7.

### For Subset Sum

To calculate subset sum without repetition, we have to create a table where rows are items of set and columns are target pieces. We will fill this table from top to bottom and from left to right. In other words, we will iterate every row and for every row we iterate every column.

|        | 0   | 10  | 20  | 30  | 40  | 50  | 60  | 70  | 80  | 90  | 100  |
|:------:|:---:|:---:|:---:|:---:|:---:|:---:|:---:|:---:|:---:|:---:|:---:|
| __0__  | 0   | 10  | 20  | 30  | 40  | 50  | 60  | 70  | 80  | 90  | 100 |
| __10__ | 0   | 0   | 10  | 20  | 30  | 40  | 50  | 60  | 70  | 80  | 90  |
| __20__ | 0   | 0   | 0   | 0   | 10  | 20  | 30  | 40  | 50  | 60  | 70  |
| __50__ | 0   | 0   | 0   | 0   | 10  | 0   | 0   | 0   | 10  | 20  | 30  |
| __70__ | 0   | 0   | 0   | 0   | 10  | 0   | 0   | 0   | 0   | 0   | 0   |

> Rows and columns have to be sorted in ascending order

Cell value equals to how close we can get to target number with current rows filled. So if the cell value is `0` it means we can create subset that will produce sum equal to column value. If the cell value is `10` that means we can produce a subset, which sum is 10 less then column value. To fill a cell value we will use this algorithm:

* subtract current cell's column value and row value. Let's call it `remainder`. This is a scenario where we assume that the best result could be done by using only subset of size one. The only item in this subset would be current row's value.
* if `remainder` is greater then 0, then take value in row above in column of value `remainder`. Let's call this value `remainder optimized`. This is a scenario, where we create a subset with current row value and the best subset for `remainder`.
* last value is cell in current column and row above. Let's call this value `skip current`. This is a scenario, where we don't want to include current row value to a finnal subset and we expect to get better result by using only previous rows.

Compare all these three values (`remainder`, `remainder optimized` and `skip current`), pick the value, that is the best. In this case we will pick a value that's closest to zero.

|        | 0   | 10                    | 20  | 30             | 40  | 50  | 60  | 70  | 80  | 90  | 100 |
|:------:|:---:|:---------------------:|:---:|:--------------:|:---:|:---:|:---:|:---:|:---:|:---:|:---:|
| __0__  | 0   | 10                    | 20  | 30             | 40  | 50  | 60  | 70  | 80  | 90  | 100 |
| __10__ | 0   | `remainder optimized` | 10  | `skip current` | 30  | 40  | 50  | 60  | 70  | 80  | 90  |
| __20__ | 0   | 0                     | 0   | `remainder`    |     |     |     |     |     |     |     |
| __50__ |     |                       |     |                |     |     |     |     |     |     |     |
| __70__ |     |                       |     |                |     |     |     |     |     |     |     |

|        | 0   | 10  | 20  | 30   | 40  | 50  | 60  | 70  | 80  | 90  | 100 |
|:------:|:---:|:---:|:---:|:----:|:---:|:---:|:---:|:---:|:---:|:---:|:---:|
| __0__  | 0   | 10  | 20  | 30   | 40  | 50  | 60  | 70  | 80  | 90  | 100 |
| __10__ | 0   | `0` | 10  | `20` | 30  | 40  | 50  | 60  | 70  | 80  | 90  |
| __20__ | 0   | 0   | 0   | `10` |     |     |     |     |     |     |     |
| __50__ |     |     |     |      |     |     |     |     |     |     |     |
| __70__ |     |     |     |      |     |     |     |     |     |     |     |

|        | 0   | 10  | 20  | 30  | 40  | 50  | 60  | 70  | 80  | 90  | 100 |
|:------:|:---:|:---:|:---:|:---:|:---:|:---:|:---:|:---:|:---:|:---:|:---:|
| __0__  | 0   | 10  | 20  | 30  | 40  | 50  | 60  | 70  | 80  | 90  | 100 |
| __10__ | 0   | 0   | 10  | 20  | 30  | 40  | 50  | 60  | 70  | 80  | 90  |
| __20__ | 0   | 0   | 0   | `0` |     |     |     |     |     |     |     |
| __50__ |     |     |     |     |     |     |     |     |     |     |     |
| __70__ |     |     |     |     |     |     |     |     |     |     |     |

### For Subset Sum With Repetition

To create a subset where items can repeat, we will have to flip the table axes. Now we will use set items as columns and target values as rows. The assumption is, that there will always be more target values then set values. This gives us opportunity to repeat a set value in finnal subset. I will also include a `best` column. This is just a visual guide to help you understand how the algorithm works. This columns is not physically present in the data structure. 

|         | 20  | 50  | 70  | best |
|:-------:|:---:|:---:|:---:|:----:|
| __0__   | -20 | -50 | -70 | -20  |
| __10__  | -10 | -40 | -60 | -10  |
| __20__  | 0   | -30 | -50 | 0    |
| __30__  | -10 | -20 | -40 | -10  |
| __40__  | 0   | -10 | -30 | 0    |
| __50__  | -10 | 0   | -20 | 0    |
| __60__  | 0   | -10 | -10 | 0    |
| __70__  | 0   | 0   | 0   | 0    |
| __80__  | 0   | -10 | -10 | 0    |
| __90__  | 0   | 0   | 0   | 0    |
| __100__ | 0   | 0   | 0   | 0    |

> Rows and columns have to be sorted in ascending order

Filling the table is basically the same as filling the table of classig subset table. We will iterate trough every row and for each row iterate trough every column. When the row is filled we will fill the besst column at the current row. Best column just stores the best result in a row. We will consider only two values

* subtract current cell's column value and row value. Let's call it `remainder`. This is a scenario where we assume that the best result could be done by using only subset of size one. The only item in this subset would be current column's value.
* if the reminder is greater then 0, then take the value in the best column in the `reminder` row. This is a scenarion where we add current column value to the best subset for the `reminder` target. Let's call this value `reminder optimized`

Current cell will have the better of the two values. In this case we will pick a value closest to zero. When the row is filled we will fill the best column with the best value in the row.

|         | 20         | 50  | 70  | best                 |
|:-------:|:----------:|:---:|:---:|:--------------------:|
| __0__   | -20        | -50 | -70 | -20                  |
| __10__  | -10        | -40 | -60 | -10                  |
| __20__  | 0          | -30 | -50 | `reminder optimized` |
| __30__  | -10        | -20 | -40 | -10                  |
| __40__  | `reminder` |     |     |                      |
| __50__  |            |     |     |                      |
| __60__  |            |     |     |                      |
| __70__  |            |     |     |                      |

|         | 20   | 50  | 70  | best |
|:-------:|:----:|:---:|:---:|:----:|
| __0__   | -20  | -50 | -70 | -20  |
| __10__  | -10  | -40 | -60 | -10  |
| __20__  | 0    | -30 | -50 | `0`  |
| __30__  | -10  | -20 | -40 | -10  |
| __40__  | `20` |     |     |      |
| __50__  |      |     |     |      |
| __60__  |      |     |     |      |
| __70__  |      |     |     |      |

|         | 20   | 50  | 70  | best |
|:-------:|:----:|:---:|:---:|:----:|
| __0__   | -20  | -50 | -70 | -20  |
| __10__  | -10  | -40 | -60 | -10  |
| __20__  | 0    | -30 | -50 | 0    |
| __30__  | -10  | -20 | -40 | -10  |
| __40__  | `0`  |     |     |      |
| __50__  |      |     |     |      |
| __60__  |      |     |     |      |
| __70__  |      |     |     |      |