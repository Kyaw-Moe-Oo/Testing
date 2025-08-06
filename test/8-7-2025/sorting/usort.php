<?php
$nums = [4, 1, 3, 5, 9, 2];
usort($nums, fn($a, $b) => $b <=> $a);  // Custom sort descending

print_r($nums);