<?php
$names = ["Moe", "Kyaw", "Oo"];
$ages = [23, 22, 24];
array_multisort($ages, SORT_ASC, $names);  // $names and $ages are sorted together

print_r($names);
echo "<br>";
print_r($ages);