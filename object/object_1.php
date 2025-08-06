<?php
    class student{
        public $name;
        public function SayHello(){
            echo "Hello!!";
        }
    }
$obj = new student();
$obj->name = "Kyaw Kyaw";
echo $obj -> name;
$obj -> SayHello();
?>