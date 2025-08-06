<?php

class CircularQueue
{
    private array $queue;
    private int $size;
    private int $front;
    private int $rear;

    public function __construct(int $size)
    {
        $this->size = $size;
        $this->queue = array_fill(0, $size, null);
        $this->front = -1; //empty
        $this->rear = -1; //empty
    }

    public function enqueue(mixed $item): bool
    {
        if ($this->isFull()) {
            return false; //not enqueue
        }

        if ($this->isEmpty()) {
            $this->front = 0; //front = 0
        }

        $this->rear = ($this->rear + 1) % $this->size; //0,1,2,3,4
        $this->queue[$this->rear] = $item; //1,2,3,4,5

        return true;
    }

    public function dequeue(): mixed
    {
        if ($this->isEmpty()) { 
            return null; //null 
        }

        $data = $this->queue[$this->front]; //1,2,3,4,5
        $this->queue[$this->front] = null; //null,null,3,4,5

        if ($this->front === $this->rear) { //
            $this->front = -1;
            $this->rear = -1;
        } else {
            $this->front = ($this->front + 1) % $this->size;
        }

        return $data;
    }

    public function display(): void
    {
        if ($this->isEmpty()) {
            echo "Queue is empty<br>";
            return;
        }

        echo "Queue (active): ";
        $i = $this->front;

        while (true) {
            echo "[$i] => " . ($this->queue[$i] === null ? "null" : $this->queue[$i]) . " ";
            if ($i === $this->rear) break;
            $i = ($i + 1) % $this->size;
        }

        echo "<br>";
    }

    // public function debug(): void
    // {
    //     echo "Queue (full): ";
    //     foreach ($this->queue as $i => $val) {
    //         echo "[$i] => " . ($val === null ? "null" : $val) . " ";
    //     }
    //     echo "<br>";
    // }

    public function isFull(): bool
    {
        return ($this->front === 0 && $this->rear === $this->size - 1) ||
               ($this->rear + 1) % $this->size === $this->front;
    }

    public function isEmpty(): bool
    {
        return $this->front === -1;
    }
}

// ---------- Test ----------
$q = new CircularQueue(5);

// Enqueue 1 to 5
$q->enqueue(1);
$q->enqueue(2);
$q->enqueue(3);
$q->enqueue(4);
$q->enqueue(5);


$q->dequeue(); // Removes 1

$q->enqueue(6);

// Display active and full queues
// $q->display(); // Expected: [0] => 1 [1] => 2 [2] => 3 [3] => 4 [4] => 5 
// $q->dequeue(); // Removes 1

// $q->debug();   // Full array dump

// Dequeue 2 items
// $q->dequeue(); // Removes 1
// $q->dequeue(); // Removes 2

// Enqueue 6, 7
// $q->enqueue(6);
// $q->enqueue(7);
// $q->enqueue(8);
// $q->enqueue(9);

// Display active queue again
$q->display(); // Expected: [2] => 3 [3] => 4 [4] => 5 [0] => 6 [1] => 7

?>
