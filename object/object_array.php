<?php

// 1. Map function (Equivalent to JavaScript numbers.map())
// echo "// 1. Map function (Equivalent to JavaScript numbers.map())\n";
$numbers = [1, 2, 3];

// array_map applies a callback function to each element of an array
$doubled = array_map(function($num) {
    return $num * 2;
}, $numbers);

print_r($doubled); // Outputs: Array ( [0] => 2 [1] => 4 [2] => 6 )


// 2. Filter function (Equivalent to JavaScript number2.filter())
// echo "\n// 2. Filter function (Equivalent to JavaScript number2.filter())\n";
$number2 = [1, 2, 3, 4];

// array_filter filters elements of an array using a callback function
$evenNumbers = array_filter($number2, function($num) {
    return $num % 2 === 0;
});

// array_filter preserves keys, so if you want a re-indexed array, use array_values
$evenNumbers = array_values($evenNumbers);

print_r($evenNumbers); // Outputs: Array ( [0] => 2 [1] => 4 )


// 3. Reduce function (Equivalent to JavaScript number3.reduce())
// echo "\n// 3. Reduce function (Equivalent to JavaScript number3.reduce())\n";
$number3 = [1, 2, 3, 4];

// array_reduce iteratively reduces the array to a single value using a callback function
// The third argument (0 in this case) is the initial value for the accumulator.
$sum = array_reduce($number3, function($carry, $item) {
    return $carry + $item;
}, 0);

echo "Sum: " . $sum . "\n"; // Outputs: Sum: 10


// 4. Find function (Equivalent to JavaScript number4.find())
// echo "\n// 4. Find function (Equivalent to JavaScript number4.find())\n";
$number4 = [1, 2, 3, 4];

$firstEven = null; // Initialize with null (similar to undefined/null in JS if not found)
foreach ($number4 as $num) {
    if ($num % 2 === 0) {
        $firstEven = $num;
        break; // Stop loop once the first match is found
    }
}

echo "First Even: " . ($firstEven !== null ? $firstEven : "Not found") . "\n"; // Outputs: First Even: 2

$number5 = [1, 2, 3];

// PHP doesn't have a direct 'some' function. We'll implement it manually.
$hasNegative = false;
foreach ($number5 as $num) {
    if ($num < 0) { // Check if the condition is met
        $hasNegative = true;
        break; // Found one, no need to check further
    }
}
echo "Has Negative: " . ($hasNegative ? 'true' : 'false') . "\n"; // Outputs: Has Negative: false

echo '<br>';
// 2. every function (Equivalent to JavaScript number6.every())
// echo "\n// 2. every function (Equivalent to JavaScript number6.every())\n";
$number6 = [1, 2, 3];

// PHP doesn't have a direct 'every' function. We'll implement it manually.
$allPositive = true;
foreach ($number6 as $num) {
    if (!($num > 0)) { // Check if the condition is NOT met for any element
        $allPositive = false;
        break; // Found one that doesn't satisfy, no need to check further
    }
}
echo "All Positive: " . ($allPositive ? 'true' : 'false') . "\n"; // Outputs: All Positive: true


// 3. findIndex function (Equivalent to JavaScript number7.findIndex())
// echo "\n// 3. findIndex function (Equivalent to JavaScript number7.findIndex())\n";
echo '<br>';
$number7 = [1, 2, 3];

// PHP doesn't have a direct 'findIndex' function. We'll implement it manually.
$index = -1; // Initialize with -1 (similar to JS if not found)
foreach ($number7 as $key => $num) {
    if ($num % 2 === 0) { // Check if the condition is met
        $index = $key; // Store the current key (index)
        break; // Found one, no need to check further
    }
}
echo "Index: " . $index . "\n"; // Outputs: Index: 1


// 4. includes function (Equivalent to JavaScript number8.includes())
// echo "\n// 4. includes function (Equivalent to JavaScript number8.includes())\n";
$number8 = [1, 2, 3];

// PHP's in_array() function directly checks if a value exists in an array.
$hasTwo = in_array(2, $number8);

echo "Has Two: " . ($hasTwo ? 'true' : 'false') . "\n"; // Outputs: Has Two: true
echo '<br>';

$nested = [1, [2], [3, [4]]];

/**
 * Custom function to flatten an array to a specified depth.
 * This mimics JavaScript's Array.prototype.flat().
 *
 * @param array $array The array to flatten.
 * @param int $depth The number of levels to flatten. Default is 1.
 * @return array The flattened array.
 */
function php_flat_array(array $array, int $depth = 1): array {
    $result = [];
    foreach ($array as $item) {
        if (is_array($item) && $depth > 0) {
            // Recursively flatten if it's an array and depth allows
            $result = array_merge($result, php_flat_array($item, $depth - 1));
        } else {
            $result[] = $item;
        }
    }
    return $result;
}

$flatArray = php_flat_array($nested, 2); // Flattening 2 levels
print_r($flatArray); // Outputs: Array ( [0] => 1 [1] => 2 [2] => 3 [3] => 4 )


// 2. flatMap function (Equivalent to JavaScript numbers.flatMap())
// echo "\n// 2. flatMap function (Equivalent to JavaScript numbers.flatMap())\n";
echo '<br>';
$number9 = [1, 2, 3];

/**
 * Custom function to mimic JavaScript's Array.prototype.flatMap().
 * Maps each element using a callback function, then flattens the result by one level.
 *
 * @param array $array The array to process.
 * @param callable $callback The callback function to apply to each element.
 * @return array The new flattened array.
 */
function php_flat_map(array $array, callable $callback): array {
    $mapped = array_map($callback, $array); // First, map the array
    $result = [];
    foreach ($mapped as $item) {
        if (is_array($item)) {
            // Flatten one level
            $result = array_merge($result, $item);
        } else {
            $result[] = $item;
        }
    }
    return $result;
}

$doubledArr = php_flat_map($number9, function($num) {
    return [$num, $num * 2];
});
print_r($doubledArr); // Outputs: Array ( [0] => 1 [1] => 2 [2] => 2 [3] => 4 [4] => 3 [5] => 6 )


// 3. Array.from(str) (Equivalent to JavaScript Array.from('hello'))
$str = 'hello';

// In PHP, you can convert a string to an array of characters directly
// or using str_split().
$arr = str_split($str);

print_r($arr); // Outputs: Array ( [0] => h [1] => e [2] => l [3] => l [4] => o )
$number10 = [1, 2, 3];
$keys = array_keys($number10);

print_r($keys); // Outputs: Array ( [0] => 0 [1] => 1 [2] => 2 )
?>