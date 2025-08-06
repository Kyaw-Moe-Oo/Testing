<?php
$arr = [9,8,7,6,5,4];
// print_r(array_chunk($array, length: 2));  // [[1,2], [3,4]]
$result = array_chunk($arr, length:5);
var_dump($result);