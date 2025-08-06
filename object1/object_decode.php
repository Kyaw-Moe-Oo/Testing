<?php
    $object='{"name":"Kyaw Kyaw","age":23,"city":"Kyaukpadaung"}';
    $deserilizedObj=json_decode($object);
    echo $deserilizedObj->name . '<br>';
    echo $deserilizedObj->age . '<br>';
    echo $deserilizedObj->city;
?>