<?php
class Stack{
  private $data=[];
  public function add($record){
    array_push($this->data, $record);
  }
  public function remove(){
    array_pop($this->data);
  }
}
$stack=new Stack();
for($i=1; $i<10 ; $i++){
  $stack->add($i);
}
// $stack = new Stack();
// $stack->add(1);
// $stack->add(2);
// $stack->add(3);
// $stack->add(4);
// $stack->add(5);
// print_r($stack);
// echo "<br>";
// $stack->remove();
// print_r($stack);
print_r($stack);
echo "<br>";
$stack->remove();
print_r($stack);
?>