<?php
    $arr1=[1,2,3];
    $arr2=$arr1;
    $arr2[0]=[99];
    var_dump($arr1);
    echo "<br>";
    var_dump($arr2);
?>