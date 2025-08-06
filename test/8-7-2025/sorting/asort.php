<?php
$age = ["Kyaw" => 23, "Nyi" => 19];
// asort($age);  // Sorted by value: ["Nyi" => 19, "Kyaw" => 23]
arsort($age);  // Sorted by value: ["Kyaw" => 23, "Nyi" => 19]

print_r($age);