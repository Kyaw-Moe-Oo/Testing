<?php
// echo "<h3>Array_Replace Example </h3>" . "<br>";
// $a = ["name" => "Kyaw", "age" => 22];
// $b = ["age" => 23];
// $replace = array_replace($a, $b);
// foreach ($replace as $r) {
//     echo $r . "<br>";
// }
// echo "<h3>Array_Merge Example </h3>" . "<br>";
// $a = ["red", "green"];
// $b = ["blue", "yellow"];
// $colors = array_merge($a, $b);  // ["red", "green", "blue", "yellow"]
// foreach ($colors as $c ) {
//     echo $c . "<br>";
// }

echo "<h3>Array_Combine Example </h3>" . "<br>";
$keys = ["name", "age"];
$values = ["Kyaw", 23];
$result = array_combine($keys, $values);
print_r($result);
// var_dump($result);
// die();

?>