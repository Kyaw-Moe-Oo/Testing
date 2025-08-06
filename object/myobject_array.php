<?php
    $number = [1,2,3];
    $reversed = array_reverse($number);
    print_r($reversed);
    echo "<br>";

    $morenumber = [4,5,6];
    $combinenum = array_merge($number, $morenumber);
    print_r($combinenum);
    echo "<br>";

    $number2 = [1,2,3,4,5];
    $slicenum = array_slice($number2,1, 3);
    print_r($slicenum);
    echo "<br>";

    $number1 = [1,2,3,4,5];
    $removedElements = array_splice($number1, 2, 1, [6, 7]);
    print_r($number1);
?>