<?php

$array = [1,2,3,4,5,6,7,8,9,10];

// Prioritize even numbers (even numbers come first)
usort($array, function($a, $b) {
    $a_priority = $a % 2 === 0 ? 0 : 1; // even = high priority
    $b_priority = $b % 2 === 0 ? 0 : 1;
    return $a_priority <=> $b_priority;
});

print_r($array);
