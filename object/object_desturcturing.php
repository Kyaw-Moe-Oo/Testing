<?php
$person = [
    'name' => 'Alice',
    'address' => [
        'street' => '456 Maple St',
        'city' => 'New York',
        'zipCode' => '10001',
    ],
];

$name = $person['name'];
$city = $person['address']['city'];
$street = $person['address']['street'];

echo "Name: " . $name . "\n" . "<br>";
echo "City: " . $city . "\n" . "<br>";
echo "Street: " . $street . "\n" . "<br>";

$personObj = [
    'firstName' => 'Bob',
    'lastName' => 'Smith',
    'age' => 40,
];

$first = $personObj['firstName'];
$last = $personObj['lastName'];
$years = $personObj['age'];

echo "First Name: " . $first . "\n" . "<br>";  // Outputs: "Bob"
echo "Last Name: " . $last . "\n" . "<br>";    // Outputs: "Smith"
echo "Age (Years): " . $years . "\n" . "<br>"; // Outputs: 40

$user = [
    'name' => 'Eve',
    'age' => 25,
];

[
    'name' => $name,
    'age' => $age
] = $user;

$country = $user['country'] ?? 'USA'; // Null coalescing operator (PHP 7.0+)

echo "Name: " . $name . "\n" . "<br>";       // Outputs: "Name: Eve"
echo "Age: " . $age . "\n" . "<br>";         // Outputs: "Age: 25"
echo "Country: " . $country . "\n" . "<br>"; // Outputs: "Country: USA" (since 'country' wasn't in the original array)

$name_explicit = $user['name'];
$age_explicit = $user['age'];
$country_explicit = isset($user['country']) ? $user['country'] : 'USA';

echo "Name (explicit): " . $name_explicit . "\n" . "<br>";
echo "Age (explicit): " . $age_explicit . "\n" . "<br>";
echo "Country (explicit): " . $country_explicit . "\n" . "<br>";

$library = [
    'name' => 'City Library',
    'location' => [
        'city' => 'New York',
        'state' => 'NY',
        'address' => '456 Book St',
    ],
    'books' => [
        [
            'title' => 'JavaScript for Beginners',
            'author' => 'John Doe',
            'year' => 2020,
            'genres' => ['Programming', 'Web Development'],
        ],
        [
            'title' => 'Advanced JavaScript',
            'author' => 'Jane Smith',
            'year' => 2022,
            'genres' => ['Programming', 'Advanced'],
        ],
    ],
];

echo "Library Name: " . $library['name'] . "\n" . "<br>";
echo "Library City: " . $library['location']['city'] . "\n" . "<br>";
echo "First Book Title: " . $library['books'][0]['title'] . "\n" . "<br>";
echo "Second Book Author: " . $library['books'][1]['author'] . "\n" . "<br>";
echo "First Book's First Genre: " . $library['books'][0]['genres'][0] . "\n" . "<br>";

foreach ($library['books'] as $book) {
    echo "Title: " . $book['title'] . "\n" . "<br>";
    echo "Author: " . $book['author'] . "\n" . "<br>";
}

foreach ($library['location'] as $key => $value) {
    echo $key . ": " . $value . "\n" . "<br>";
}

[
    'name' => $name,
    'location' => $location, // $location will be the nested array
    'books' => $books         // $books will be the array of books
] = $library;

echo "Name: " . $name . "\n" . "<br>"; // Outputs: "Name: City Library"
echo "Location City: " . $location['city'] . "\n" . "<br>"; // Outputs: "Location City: New York"

[
    'city' => $city,
    'state' => $state
] = $library['location'];

echo "City: " . $city . "\n" . "<br>";   // Outputs: "City: New York"
echo "State: " . $state . "\n" . "<br>" ; // Outputs: "State: NY"



?>