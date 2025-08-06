<?php
$nums = [1, 2, 3];
$squares = array_map(fn($n) => $n * $n , $nums);  // [1, 4, 9]
var_dump($squares);
echo "<br>";
