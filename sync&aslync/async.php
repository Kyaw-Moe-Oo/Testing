<?php 
    echo "async start" . '<br>';
    function asynctask() {
        echo "This is Asynchronous task.";
    }
    sleep(5 );
    echo "async end";
    echo "<br>";
    asynctask();
    
    
?>