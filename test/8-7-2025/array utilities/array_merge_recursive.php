<?php
$a = ["color" => ["Kyaw"]];
$b = ["color" => ["Moe"]];
$c = ["color" => ["Oo"]];

$r = array_merge_recursive($a, $b, $c);  // ["color" => ["red", "blue"]]

print_r($r);
echo "<br>";
var_dump($r);

?>