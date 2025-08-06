<?php
use Animal as GlobalAnimal;
abstract class Animal // class 
{
    abstract public function makeSound(); // method
    public function eat()  //concrete method
    {
        echo "eating";
    }
}
// class Dog extends Animal
// {
//     public function makeSound()
//     {
//         echo "Bark";
//     }
// }

// $animal = new Dog();
// $animal->makeSound(); // Output: Bark
// echo "\n";
// $animal->eat();   