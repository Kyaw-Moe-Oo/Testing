<?php

// 1. Defining the array of products (equivalent to JavaScript const products = [...])
$products = [
    [
        'id' => 1,
        'name' => 'Laptop',
        'price' => 799,
        'category' => 'Electronics'
    ],
    [
        'id' => 2,
        'name' => 'Phone',
        'price' => 499,
        'category' => 'Electronics'
    ],
    [
        'id' => 3,
        'name' => 'T-shirt',
        'price' => 25,
        'category' => 'Apparel'
    ],
    [
        'id' => 4,
        'name' => 'Coffee Maker',
        'price' => 89,
        'category' => 'Home Appliances'
    ],
];

// echo "// 2. Accessing the name of the second product (Equivalent to products[1].name)\n";
echo "Product Name: " . $products[1]['name'] . "\n" . "<br>"; // Outputs: "Product Name: Phone"

// echo "\n// 3. Looping over the array to display product details (Equivalent to products.forEach())\n";
foreach ($products as $product) {
    echo $product['name'] . " - $" . $product['price'] . "\n" . "<br>";
}

// echo "\n// 4. Filter with PHP's array_filter function (Equivalent to products.filter())\n";

// PHP's array_filter function is used for filtering.
// It takes the array to filter and a callback function.
// The callback function should return true for elements to keep, and false to discard.
$electronics = array_filter($products, function($product) {
    return $product['category'] === 'Electronics';
});

// To display the filtered array, you can use print_r or var_dump
echo "Filtered Electronics Products:\n";
print_r($electronics);

echo "<br>";

$discountedProducts = array_map(function($product) {
    // Create a copy of the original product array (similar to JavaScript's spread operator ...product)
    $newProduct = $product;

    // Apply the 10% discount
    $newProduct['price'] = $product['price'] * 0.9;

    return $newProduct;
}, $products);

// To display the new array, you can use print_r or var_dump
echo "Discounted Products:\n";
print_r($discountedProducts);
/*
Expected Output for print_r($electronics):

Array
(
    [0] => Array
        (
            [id] => 1
            [name] => Laptop
            [price] => 799
            [category] => Electronics
        )

    [1] => Array
        (
            [id] => 2
            [name] => Phone
            [price] => 499
            [category] => Electronics
        )

)
*/

?>