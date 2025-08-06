<?php
$nums = [1, 2, 3, 4];
$even = array_filter($nums, fn($n) => $n % 2 == 0);  // [2, 4]
print_r($even);