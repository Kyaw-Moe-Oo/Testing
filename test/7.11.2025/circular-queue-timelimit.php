<?php
class CircularQueue {
    private $queue = [];
    private $limit;
    private $head = 0;
    private $tail = 0;
    private $count = 0;

    public function __construct(array $data) {
        $this->limit = count($data);
        $this->queue = array_fill(0, $this->limit, null);
        
        foreach ($data as $item) {
            $this->enqueue($item);
        }
    }

    public function enqueue($value) {
        if ($this->count == $this->limit) {
            $this->head = ($this->head + 1) % $this->limit;
        } else {
            $this->count++;
        }

        $this->queue[$this->tail] = $value;
        $this->tail = ($this->tail + 1) % $this->limit;
    }

    public function display() {
        for ($i = 0; $i < $this->count; $i++) {
            $index = ($this->head + $i) % $this->limit;
            echo $this->queue[$index] . " ";
        }
        echo PHP_EOL;
    }

    public function dequeueWithDelay($firstDelay = 5, $nextDelay = 2) {
        echo "Starting dequeue with delay...\n";
        for ($i = 0; $i < $this->count; $i++) {
            if ($i == 0) {
                sleep($firstDelay); // wait 5s before first removal
            } else {
                sleep($nextDelay); // wait 2s for next removals
            }

            $index = ($this->head + $i) % $this->limit;
            echo "Dequeued: " . $this->queue[$index] . " at " . date("H:i:s") . PHP_EOL;
        }
    }
}

// Initialize the queue
$q = new CircularQueue([1, 2, 3, 4, 5]);

// Show queue contents
echo "Initial Queue: ";
$q->display();

// Add new elements to show overwrite behavior
$q->enqueue(6);
$q->enqueue(7);
echo "After enqueues: ";
$q->display(); // Output should be 3 4 5 6 7

// Start timed dequeue
$q->dequeueWithDelay();
$q->display(); // Output should be 3 4 5 6 7




