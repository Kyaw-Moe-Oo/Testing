<?php
class Queue{
  private $data=[];
  public function add($record){
    array_unshift($this->data, $record);
  }
  public function remove(){
    array_pop($this->data);
  }
  public function display(){
    print_r($this->data);
  }

}
$queue=new Queue();
$queue->add(1);
$queue->add(2);
$queue->add(3);
$queue->add(4);
$queue->add(5);
$queue->add(6);
$queue->display();

$queue->remove();
$queue->display();

$queue->remove();
$queue->display();
?>