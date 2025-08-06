<?php

// Input: arr2 = [1, 4, 3, 2, 6, 5]
// Output: [5, 6, 2, 3, 4, 1]

// PHP Program to reverse an array using a temporary array and a loop

// function to reverse an array
function reverseArray($arr2) {
    // Edge case: if the array is empty
    if (empty($arr2)) {
        return 'Array is empty.'; // Or throw an error, depending on use case
    }

    $n = count($arr2); // Get the number of elements in the array
    $temp = []; // Initialize an empty array to store the reversed elements

    for ($i = 0; $i < $n; $i++) {
        // Place elements from arr2 into temp in reverse order
        $temp[$i] = $arr2[$n - 1 - $i];
    }

    return $temp;
}

$arr2 = [1, 4, 3, 2, 6, 5];
$result = reverseArray($arr2);
echo 'Using temp array: ';
print_r($result); // print_r is used to display array contents in PHP

/* O(N) Time and O(N) Space */

?>