<?php
    // $fruits = ['banana', 'apple', 'mango'];
    // foreach ($fruits as $index => $fruit) {
    //     echo "$index . ':' . $fruit . '<br>'" ;
    // }

    
$numbers = range(0, 9);

foreach ($numbers as $key => $value) {
    echo "$key : $value" . PHP_EOL;
}



$fruits = ['apple', 'banana', 'orange'];
foreach ($fruits as $key => $value) {
    echo "$key = $value" . PHP_EOL;
}



$person = ['name'=>'Kyaw', 'age'=>18, 'city'=>'Yangon'];
foreach ($person as $key => $value) {
    echo "$key = $value" . PHP_EOL;
}



$numbers = [1, 2, 3, 4, 5];
foreach ($numbers as $num) {
    echo "$num squared = " . ($num * $num) . PHP_EOL;
}
