<?php
// $sales = [ 
//     ['p1' => 5],
//     ['p2' => 10],
//     ['p3' => 12],
//     ['p4' => 20],
//     ['p5' => ['p5-1' => 25], ['p5-2' => 10]]
// ];

// $result = [];
// $total = 0;

// function flattenSales($data, &$result, &$total) {
//     foreach ($data as $item) {
//         $key = key($item);
//         $value = current($item);

//         if (is_array($value)) {
//             flattenSales([$value], $result, $total);
//         } else {
//             $result[$key] = $value;
//             $total += $value;
//         }
//     }
// }

// flattenSales($sales, $result, $total);

// arsort($result);

// echo "Descending Order:<br>";
// foreach ($result as $product => $amount) {
//     echo "$product => $amount<br>";
// }

// echo "<br>Total amount: " . $total . "<br>";

// $topProduct = key($result);
// $topamount = current($result);

// echo "Top Selling Product: $topProduct (topAmount $topamount)<br>";
// echo "Top Selling Person: $topProduct (topAmount $topamount)";

$sales = [ 
    ['p1' => 5],
    ['p2' => 10],
    ['p3' => 12],
    ['p4' => 20],
    ['p5' => ['p5-1' => 25], ['p5-2' => 10]]
];

$result = [];
$total = 0;

function flattenSales($data, &$result, &$total) {
    foreach ($data as $item) {
        $key = key($item);
        $value = current($item);

        if (is_array($value)) {
            flattenSales([$value], $result, $total);
        } else {
            $result[$key] = $value;
            $total += $value;
        }
    }
}

flattenSales($sales, $result, $total);

arsort($result);

echo "Descending Order:<br>";
foreach ($result as $product => $amount) {
    echo "$product => $amount<br>";
}

echo "<br>Total amount: " . $total . "<br>";

$topProduct = key($result);
$topamount = current($result);

echo "Top Selling Product: $topProduct (topAmount $topamount)<br>";
echo "Top Selling Person: $topProduct (topAmount $topamount)";
?>