<?php

class CircularQueue {
    private array $queue;
    private int $front;
    private int $rear;
    private int $capacity;
    private int $size;

    public function __construct(int $capacity) {
        $this->capacity = $capacity;
        $this->queue = array_fill(0, $capacity, null);
        $this->front = 0;
        $this->rear = 0;
        $this->size = 0;
    }

    public function enqueue(mixed $value): void {//1,2,3
        $this->queue[$this->rear] = $value;
        $this->rear = ($this->rear + 1) % $this->capacity;
        if ($this->size < $this->capacity) {
            $this->size++;
        } else {
            $this->front = ($this->front + 1) % $this->capacity;
        }
    }

    public function dequeue(): mixed {
        if ($this->size === 0) {
            echo "Queue is empty\n";
            return null;
        }
        $value = $this->queue[$this->front];
        $this->queue[$this->front] = null;
        $this->front = ($this->front + 1) % $this->capacity;
        $this->size--;
        return $value;
    }

    public function Display(): array {
        return $this->queue;
    }
}

$q = new CircularQueue(5);

$q->enqueue(1);
$q->enqueue(2);
$q->enqueue(3);
// $q->enqueue(4);
// $q->enqueue(5);

$q->Display();
echo "<br>";
$q->dequeue();
$q->Display();

echo "<br>";


$q->enqueue(6);
$q->Display();


// $q->enqueue(7);
// $q->enqueue(8);
// $q->enqueue(9);
// $q->enqueue(10);
// $q->enqueue(11);

// print_r($q->getQueue());