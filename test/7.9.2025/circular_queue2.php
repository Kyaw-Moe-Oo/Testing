<?php
class CircularQueue {
    private $queue;
    private $size;

    public function __construct(array $items) {
        $this->queue = $items;
        $this->size = count($items);
    }

    public function dequeue() {
        for ($i = 0; $i < $this->size; $i++) {
            if ($this->queue[$i] !== null) {
                echo "Removed: {$this->queue[$i]}\n";
                $this->queue[$i] = null;
                return;
            }
        }
        echo "Queue is empty\n";
    }

    public function enqueue($item) {
        for ($i = 0; $i < $this->size; $i++) {
            if ($this->queue[$i] === null) {
                $this->queue[$i] = $item;
                echo "Inserted: $item at index $i\n";
                return;
            }
        }
        echo "Queue is full\n";
    }

    public function display() {
        echo "Queue: ";
        foreach ($this->queue as $val) {
            echo ($val === null ? "_" : $val) . " ";
        }
        echo "\n";
    }
}

$q = new CircularQueue([1, 2, 3, 4, 5]);
$q->display();    // 1 2 3 4 5
$q->dequeue();    // Remove 1 => index 0 is now null
$q->enqueue(6);   // Insert 6 => replaces null slot at index 0
$q->display();    // 6 2 3 4 5
// $q->dequeue();
// $q->enqueue(7);
// $q->display();
?>