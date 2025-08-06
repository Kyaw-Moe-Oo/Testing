<?php 
$data = ["x" => 10, "y" => 20];
$first = array_key_first($data);  // "x"
$last = array_key_last($data);    // "y"

echo "array key first : ";
print_r($first);
echo "<br>";
echo "array key last : ";
print_r($last);

