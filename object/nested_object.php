<?php

$company = [
    'name' => 'Tech Corp',
    'address' => [
        'street' => '123 Tech Lane',
        'city' => 'Techville',
        'zipCode' => '12345',
    ],
    'employees' => [
        [
            'name' => 'Alice',
            'role' => 'Developer',
        ],
        [
            'name' => 'Bob',
            'role' => 'Designer',
        ],
    ],
];

// echo "// Accessing nested object (address)\n";
echo "City: " . $company['address']['city'] . "\n" . "<br>"; // Outputs: "City: Techville"

// echo "\n// Accessing array of objects (employees)\n";
echo "First Employee Name: " . $company['employees'][0]['name'] . "\n" . "<br>"; // Outputs: "First Employee Name: Alice"
echo "Second Employee Role: " . $company['employees'][1]['role'] . "\n" . "<br>"; // Outputs: "Second Employee Role: Designer"

?>