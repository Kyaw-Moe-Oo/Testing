<?php
class Queue {
   public $data = [];
   public function add($record) {
      array_unshift ($this->data, $record);
   }
   public function remove() {
      array_pop( $this->data);
   }
   public function peek() {
      return count($this->data);
   }
   public function size() {
      return count($this->data);
   }
   public function empty() {
      return count($this->data) === 0;
   }
}
$q = new Queue();
for ($i = 1; $i <= 5; $i++) {
   $q->add($i);
}
echo "This is the adding values in the queue: ";
print_r($q->data);
echo "\n";
echo "<br>";
$q->remove();
echo "After removing values from the queue: ";
print_r($q->data);
echo "\n";
echo "<br>";
echo "This is the peek value of the queue: (" . $q->peek() . ")\n";
echo "<br>";
echo "This is the size of the queue: " . $q->size() . "\n";
echo "<br>";
echo "This is the empty value of the queue: " . ($q->empty() ? 'true' : 'false') . "\n";
?>