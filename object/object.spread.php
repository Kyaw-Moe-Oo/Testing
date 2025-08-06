<?php

// echo "// 1. Cloning an associative array (equivalent to JavaScript Object Spread for cloning)\n";
$personObj = ['name' => 'Alice', 'age' => 25];

// Method 1: Using array_merge (common and widely compatible)
// This effectively creates a new array with the contents of $personObj
$personClone = array_merge([], $personObj);

// Method 2: Using the array spread operator (PHP 7.4+ for non-numeric keys)
// This is the closest equivalent to JavaScript's {...personObj}
// $personClone = [...$personObj]; // Uncomment if you are on PHP 7.4+ and prefer this

print_r($personClone);
echo '<br>';
// The concept of '===' (strict equality for object identity) doesn't directly map
// for arrays in PHP in the same way. array_merge always creates a new array,
// so it's conceptually a different "object" (array in PHP terms).
// If you were comparing array references (not common), they would be different.


// echo "\n// 2. Merging associative arrays (equivalent to JavaScript Object Spread for merging)\n";
$address = ['city' => 'Wonderland', 'street' => '123 Main St'];
$person = ['name' => 'Alice', 'age' => 25];

// Method 1: Using array_merge (most common and versatile for merging)
// If keys overlap, the value from the array later in the argument list wins.
$merged = array_merge($person, $address);

// Method 2: Using the array spread operator (PHP 7.4+ for non-numeric keys)
// This is the closest syntactic equivalent to JavaScript's {...person, ...address}
// $merged = [...$person, ...$address]; // Uncomment if you are on PHP 7.4+ and prefer this

print_r($merged);
echo '<br>';

// echo "\n// 3. Renaming while destructuring (PHP Array Destructuring with alias - Requires PHP 7.1+)\n";
$personObjRe = ['name' => 'Alice', 'age' => 25];

// Destructure and rename 'name' to 'fullName'
[
    'name' => $fullName, // 'name' is the key in the array, $fullName is the new variable name
    'age' => $age
] = $personObjRe;

echo "Full Name: " . $fullName . "\n"; // Outputs: "Full Name: Alice"
echo '<br>';
echo "Age: " . $age . "\n";           // Outputs: "Age: 25"


?>