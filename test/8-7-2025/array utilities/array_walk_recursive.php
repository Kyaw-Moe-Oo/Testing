<?php
// $data = ["a" => 1, "b" => ["c" => 2]];
// array_walk_recursive($data, function($v, $k) {
//     echo "$k: $v\n";
// });

// print_r($data);
// var_dump($data);

$data = [
    "a" => 1,
    "b" => ["c" => 2]
];

array_walk_recursive($data, function($v, $k) {
    echo "$k: $v\n";
});
echo "<br>";

$data = [ 
    "name" => "Kyaw Moe Oo",
    "detail" => [
        "country" => "Kyaukpadaung"
    ]
];

array_walk_recursive($data, function($v, $k) {
    echo "$k : $v ,\n";
});