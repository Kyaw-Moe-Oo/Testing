<?php
$num = [1,2,3,4];
$total = array_reduce($num, fn($carry, $item) => $carry + $item);  // 6
print_r($total);
