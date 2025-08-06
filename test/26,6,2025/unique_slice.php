<?php
$arr = [1, 2, 2, 5, 6, 6, 8, 9];
$unique = [];

for ($i = 0; $i < count($arr); $i++) {
    $current = $arr[$i];

    // Create a new array excluding current index using array_slice
    $before = array_slice($arr, 0, $i); // elements before current
    $after = array_slice($arr, $i + 1); // elements after current
    $rest = array_merge($before, $after); // full array except current element

    if (!in_array($current, $rest)) {
        $unique[] = $current;
    }
}

print_r($unique);
?>
<?php
$sales = [ 
    ['p1' => 5],
    ['p2' => 10],
    ['p3' => 12],
    ['p4' => 20],
    ['p5' => ['p5-1' => 25, 'p5-2' => 10]]
];

$result = [];
$total = 0;

foreach ($sales as $item) {
    $key = key($item);
    $value = current($item);

    if (is_array($value)) {
        $result += $value;
        $total += array_sum($value);
    } else {
        $result[$key] = $value;
        $total += $value;
    }
}

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
