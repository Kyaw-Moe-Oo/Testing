<?php
$a = [1, 2, 3];
$b = [2, 3, 4];
$difference = array_diff($a, $b);  // [1]
$common = array_intersect($a, $b);  // [2, 3]

print_r($difference);
echo "<br>";
print_r($common);