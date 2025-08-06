<?php

// Equivalent of JavaScript 'const person = { name: 'Alice', age: 25 };'
$person = [
    'name' => 'Alice',
    'age' => 25,
];

// Equivalent of JavaScript 'console.log(Object.keys(person));'
$keys = array_keys($person);

// To display the keys, you can use print_r or var_dump
print_r($keys);

$values = array_values($person);

// To display the values, you can use print_r or var_dump
print_r($values);
/*
Expected Output:

Array
(
    [0] => name
    [1] => age
)
*/

?>