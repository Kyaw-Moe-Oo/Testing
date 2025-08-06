<?php
$data = ["name" => "John", "age" => 25];
extract($data);
// Now $name = "John", $age = 25

print_r($data);