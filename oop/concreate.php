<?php
class Car 
{
    public $name; //can know everybody// access modify 
    private $account; // only private //
    protected $familyName; // 
    public function drive()
    {
        echo "Driving!";
    }
    public function getName()
    {

    }
    public function setName()
    {
        
    }
}
$myCar = new Car();// instantiation
$myCar1 = new Car();// instantiation
$myCar2 = new Car();// instantiation
?>