<?php
class Dog
{
    public $name;
    public function __construct() {}
    public function dark()
    {
        echo "$this->name is barking";
    }
}
$dog = new Dog();
$dog->name = "sofia";
$dog->dark();