<?php
    $person = [
        'name' => 'mg mg',
        'age' => 22,
    ];
    $entries = [];
    foreach ($person as $key => $value) {
    $entries[] = [$key, $value];
    print_r($entries);
    }
?>