<?php
$a = ["a" => "red", "b" => "green"];
$b = ["a" => "red", "b" => "blue"];
// $diff = array_diff_assoc($a, $b);  // ["b" => "green"]
$diff = array_intersect_assoc( $a, $b);

print_r($diff);