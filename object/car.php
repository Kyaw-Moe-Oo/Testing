<?php

// Equivalent to JavaScript 'const car = { ... }' using a PHP Class
class Car {
    // Properties (equivalent to JavaScript object properties)
    public $make;
    public $model;
    public $year;

    // Constructor to initialize the object (similar to JavaScript's initial object creation)
    public function __construct($make, $model, $year) {
        $this->make = $make;
        $this->model = $model;
        $this->year = $year;
    }

    // Method to get car information (equivalent to JavaScript 'getCarInfo' function)
    public function getCarInfo() {
        // Using string interpolation with curly braces for properties within a string (PHP 7.4+)
        return "{$this->year} {$this->make} {$this->model}";
        // For older PHP versions or alternative:
        // return $this->year . " " . $this->make . " " . $this->model;
    }

    // Method to update the year (equivalent to JavaScript 'updateYear' function)
    public function updateYear($newYear) {
        $this->year = $newYear;
    }
}

// Create an instance of the Car class (equivalent to the initial JavaScript car object)
$car = new Car('Tesla', 'Model S', 2022);

// Calling methods and accessing properties (equivalent to JavaScript console.log calls)
echo $car->getCarInfo() . "\n" . "<br>"; // Outputs: 2022 Tesla Model S

$car->updateYear(2023); // Update the year

echo $car->getCarInfo() . "\n"; // Outputs: 2023 Tesla Model S

?>