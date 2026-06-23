<?php
    $i= 0;
    do {
        echo "number = $i" . PHP_EOL;
        $i++;
    }while($i<5);





$fruits = ['apple','banana','orange','mango'];
$i = 0;
$count = count($fruits);
do {
    echo $fruits[$i] . PHP_EOL;
    if ($fruits[$i] === 'orange') break;
    $i++;
} while ($i < $count);




$numbers = [5, 3, 7, 6, 4];
$i = 0;
$sum = 0;
do {
    $sum += $numbers[$i];
    echo "Sum = $sum" . PHP_EOL;
    $i++;
} while ($sum <= 20 && $i < count($numbers));
