<?php
function getData($callback){
    $data="Raw Data";
    $callback($data);
}
function processData($data, $callback){
  $processed=strtoupper($data);
  $callback($processed);
}
function saveData($data, $callback){
  $saved="Saved: " . $data;
  $callback($saved);
}
function sendConfirmation($data, $callback){
  $confirmation="Confirmation sent for:" . $data;
  $callback($confirmation);
}

  getData(function($data){
    processData($data, function($processed){
      saveData($processed, function($saved){
        sendConfirmation($saved, function($confirmation){
          echo ("All operations completed successfully");
          echo $confirmation . "\n";
        });
      });
    });
  });
?>