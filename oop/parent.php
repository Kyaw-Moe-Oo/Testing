<?php
class Animal
{
    public function Speek()
    {
        echo "Animal Sound";
    }
}
class Dog extends Animal
{
    public function Speek()
    {
        echo "Bark";
    }
    public function parentSound()
    {
        parent::Speek();
    }
}
var_dump(Animal(dog));
?>