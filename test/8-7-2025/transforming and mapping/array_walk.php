<?php
$num = [1,2,3];
$result = array_walk($num, fn(&$n) => $n *= 10);  // $num becomes [10, 20, 30]
var_dump($result);
print_r($num);