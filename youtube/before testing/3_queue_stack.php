<?php
require_once "3_stack1.php";
class Queue {
   public $queue = [];
   public $stack1;
   public $stack2;
   public function __construct() {
      $this->stack1 = new Stack();
      $this->stack2 = new Stack();
   }
   public function add($record){
      $this->stack1->push($record);
   }
   public function remove() {
      // while ($this->stack1->peek()){
      //    $this->stack2->push($this->stack1->pop());
      // }
      $this->refill($this->stack1, $this->stack2);
      if ($this->stack2->peek()) {
      $record = $this->stack2->pop();
      // print_r($record);
      array_unshift($this->queue,$record);
      }
      // while ($this->stack2->peek()){
      //    $this->stack1->push($this->stack2->pop());
      // }
      $this->refill($this->stack2, $this->stack1);
   }
   public function refill($source, $destination) {
      while ($source->peek()){
         $destination->push($source->pop());
      }
   }
}
//test Queue on two stacks
$queue = new Queue();

// $queue->add(1);
// $queue->add(2);
// $queue->add(3);
// $queue->add(4);
// $queue->add(5);
// $queue->remove();
// $queue->remove();
// $queue->remove();
// $queue->add(6);
// $queue->remove();
// $queue->remove();
// $queue->add(7);
// $queue->remove();
// $queue->remove();
$numArray = [1, 2, 3, 4, 5, 6];
// for ($i = 1; $i <= count($numArray); $i++) {
//     $queue->add($i);
// }
// for ($i = 1; $i <= count($numArray); $i++) {
//     $queue->remove();
// }
foreach ($numArray as $num) {
   $queue->add($num);
}
foreach ($numArray as $_) {
   $queue->remove();
}
print_r($queue->queue);