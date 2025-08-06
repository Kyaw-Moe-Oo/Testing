<?php
  function Great($name){
    echo "Hello," . $name;
  }
  function ProcessorUserInput($callback){
    $name= 'Kyaw Moe Oo';
    $callback($name);
  }

function settimeout($callback, $milliseconds) {
  usleep($milliseconds);
  $callback();

}
ProcessorUserInput('Great');
settimeout(function(){
  echo "This is a delayed message.\n";
},5000);
?>