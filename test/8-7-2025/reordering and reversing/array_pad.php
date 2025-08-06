<?php
$a = [1, 2];
$pad = array_pad($a, 5, 0);  // [1, 2, 0, 0, 0]

print_r($pad);