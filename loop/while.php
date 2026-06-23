<?php 
    $i = 0;
    while ($i < 5) {
        echo "number = $i" . PHP_EOL;
        $i++;
    }



$i = 0;
while ($i <= 10) {
    if ($i > 5) break;
    echo "num = $i" . PHP_EOL;
    $i++;
}




$fruits = ['apple','banana','orange'];
$count = count($fruits);
$i = $count;
while ($i-1 >= 0) {
    echo "fruit = " . $fruits[$i] . PHP_EOL;
    // $i--;
}
