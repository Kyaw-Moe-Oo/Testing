<?php 
$a = [1, 2, 3, 4, 5, 6, 7, 8, 9];
array_splice($a, 4, 2);  // Removes 2, 3 → $a = [1, 4]

print_r($a);