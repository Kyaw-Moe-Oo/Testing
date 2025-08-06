<?php
$sale = [
    ['p1' => 5],
    ['p2' => 10],
    ['p3' => 12],
    ['p4' => 20],
    ['p5' => 19]
];

// Sort in descending order
usort($sale, function($a, $b) {
    return array_values($b)[0] <=> array_values($a)[0];
});

// Top selling product
$top = $sale[0]; // first item after sorting

$product = array_keys($top)[0];
$sold = array_values($top)[0];

echo "Top-Selling Product: $product (Sold: $sold)\n";
?>
