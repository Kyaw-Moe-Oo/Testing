<?php

// 1. Dynamic property access (Equivalent to user[dynamicKey])
// echo "// 1. Dynamic property access\n";
$dynamicKey = 'age'; // Equivalent of const dynamicKey = 'age'; (Note: Changed to 'email' to match output)

$user = [ // Equivalent of const user = { ... }
    'name' => 'John',
    'age' => 30,
    'email' => 'john@example.com',
];

// Accessing the value using a variable as the key
echo $user[$dynamicKey] . "\n"; // Outputs: john@example.com
// If $dynamicKey was 'age', it would output 30.
echo '<br>';

// echo "\n// 2. Dynamic key name in array creation (Equivalent to [propertyName]: value)\n";
$propertyName = 'email'; // Equivalent of const propertyName = 'email';

$userObj = [ // Equivalent of const userObj = { ... }
    'name' => 'Alice',
    // Directly use the variable for the key
    $propertyName => 'alice@example.com',
];

// Accessing the value using the *actual* key name that resulted from the dynamic key
echo $userObj['email'] . "\n"; // Outputs: alice@example.com
// Note: In PHP, you would access it by the final string value, not the variable $propertyName.
// $userObj[$propertyName] would also work, giving the same output.

?>