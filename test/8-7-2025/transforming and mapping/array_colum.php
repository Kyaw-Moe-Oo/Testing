<?php
$students = [
  ["id" => 1, "name" => "Kyaw"],
  ["id" => 2, "name" => "Moe"]
];
$names = array_column($students, "name");  // ["Kyaw", "Moe"]
print_r($names);