<?php 
    echo "<h1>Array Example</h1>";
    $fruit = array("Apple", "Banana", "Cherry");
    foreach ($fruit as $f) {
        echo "1." . $f . "<br>";
    }
    echo "<h1>Array_Fill Example</h1>" . "<br>";
    $filled = array_fill(0, 5, "Orange");
    foreach ($filled as $f) {
        echo "2." . $f . "<br>";
    }
    echo "<br>";
    
    
    
?>