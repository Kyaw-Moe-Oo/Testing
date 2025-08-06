<?php
$data = ["Name" => "Kyaw", "Age" => 23];
$lower = array_change_key_case($data, CASE_LOWER);  // ["name" => "Kyaw", "age" => 23]
// var_dump($lower);
print_r($lower);