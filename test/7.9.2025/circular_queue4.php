<?php
class CircularQueue {
    private $queue = [];
    private $limit;
    private $head = 0;
    private $tail = 0;
    private $count = 0;

    public function __construct(array $data) {
        $this->limit = count($data);//3
        $this->queue = array_fill(0, $this->limit, null);//queue=[null,null,null]
        
        foreach ($data as $item) {
            $this->enqueue($item);
        }
    }

    public function enqueue($value) {
        if ($this->count == $this->limit) {
            // Overwrite oldest (head moves forward)
            $this->head = ($this->head + 1) % $this->limit;
            // echo "Overwriting at index $this->tail: $value\n";
        } else {
            $this->count++;
            // echo "Enqueue: $value at index $this->tail\n";
        }

        $this->queue[$this->tail] = $value;
        $this->tail = ($this->tail + 1) % $this->limit;
    }

    public function display() {
        
        for ($i = 0; $i < $this->count; $i++) {
            $index = ($this->head + $i) % $this->limit;
            print_r($this->queue[$index]);
        }
        echo "\n";
    }
}
$q = new CircularQueue([1, 2, 3]);
$q->display();        // Output: 1 2 3 4 5

$q->enqueue(6);       // Overwrites 1
$q->enqueue(7);       // Overwrites 2
$q->display();        // Output: 3 4 5 6 7