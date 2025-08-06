<?php
    $person = [
        'name' => 'Kyaw',
        'age' => 23,
        'address' => [
            'township' => 'Popa',
            'city' => 'Mandalay',
        ],
    ];
    $name = $person['name'];
    $age = $person['age'];
    $township = $person['address']['township'];
    echo "Name:" . $name . "<br>";
    echo "Age:" . $age . "<br>";
    echo "Township:" . $township . "<br>";
?>