<?php
    $object=[
        'name' => "Kyaw",
        function (){
            return "Hello!";
        },
    ];
    $serilizedObj=json_encode($object);
    echo $serilizedObj;
?>