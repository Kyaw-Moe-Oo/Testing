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
        $this->queue = array_fill(0, $size, null); //null ,null ,null ,null ,null        
        $this->front = -1; //front = 0,
        $this->rear = -1; //rear = 0
    }

    public function enqueue(mixed $item): bool
    {
        if ($this->isFull()) {
            echo "Queue is full<br>"; //if Queue is full
            return false; //false
        }

        if ($this->isEmpty()) { // if Queue is empty
            $this->front = 0; // null
        }

        $this->rear = ($this->rear + 1) % $this->size;
        $this->queue[$this->rear] = $item;

        echo "Inserted: $item<br>";
        return true;
    }

    public function dequeue(): mixed
    {
        if ($this->isEmpty()) {
            echo "Queue is empty<br>";
            return null;
        }

        $data = $this->queue[$this->front];
        $this->queue[$this->front] = null;

        if ($this->front === $this->rear) {
            $this->front = -1;
            $this->rear = -1;
        } else {
            $this->front = ($this->front + 1) % $this->size;
        }

        echo "Removed: $data<br>";
        return $data;
    }

    public function display(): void
    {
        if ($this->isEmpty()) {
            echo "Queue is empty<br>";
            return;
        }

        echo "Queue contents: ";
        $i = $this->front;

        while (true) {
            echo $this->queue[$i] . " ";
            if ($i === $this->rear) break;
            $i = ($i + 1) % $this->size;
        }

        echo "<br>";
    }

    public function debug(): void
    {
        echo "Queue (full): ";
        foreach ($this->queue as $i => $val) {
            echo "[$i] => " . ($val === null ? "null" : $val) . " ";
        }
        // echo "<br>Front: {$this->front}, Rear: {$this->rear}<br>";
    }

    public function isFull(): bool {
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

// Enqueue 5 elements
$q->enqueue(1);
$q->enqueue(2);
$q->enqueue(3);
$q->enqueue(4);
$q->enqueue(5); // Queue full now
$q->enqueue(6); // Should show full

// echo "<br>";
// $q->display();
// $q->debug();
// echo "<br>";

// Dequeue 2 elements
$q->dequeue();
$q->dequeue();

echo "<br>";
$q->display();
$q->debug();
echo "<br>";

// // Add more elements
$q->enqueue(6);
$q->enqueue(7);

// echo "<br>";
// $q->display();
$q->debug();
// echo "<br>";

// // Dequeue 1 and Enqueue 8
// $q->dequeue();
// $q->enqueue(8);

// echo "<br>";
// $q->display();
// $q->debug();
// echo "<br>";
?>
