<?php
class Student {
    public $name;
    public $grade;

    public function __construct($name, $grade) {
        $this->name = $name;
        $this->grade = $grade;
    }
}

class ClassRoom {
    public $name;
    public $students = [];

    public function __construct($name) {
        $this->name = $name;
    }

    public function addStudent(Student $student) {
        $this->students[] = $student;
    }
}

class School {
    public $schoolName;
    public $classes = [];

    public function __construct($schoolName) {
        $this->schoolName = $schoolName;
    }

    public function addClass(ClassRoom $classRoom) {
        $this->classes[] = $classRoom;
    }
}
// Create Students
$student1 = new Student("Aung Aung", "Grade 5");
$student2 = new Student("Hla Hla", "Grade 5");

// Create Class and Add Students
$class = new ClassRoom("Class A");
$class->addStudent($student1);
$class->addStudent($student2);

// Create School and Add Class
$school = new School("Shining Star School");
$school->addClass($class);

// Print Structure
echo "<pre>";
print_r($school);
echo "</pre>";

?>