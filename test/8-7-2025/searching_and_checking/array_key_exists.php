<?php
echo "<h3>Array_Combine Example </h3>" . "<br>";
$data = ["id" => 1, "name" => "Kyaw"];
$Name = array_key_exists("name", $data);  // true
// print_r($Name);
var_dump($Name);