<?php

class circularQueueWithTiming{
    private array $queue;
    private int $size;
    private int $front;
    private int $rear;


    public function __construct(int $size)
    {
        $this->size = $size;
        $this->queue = array_fill(0, $size, null);
        $this->front = -1;
        $this->rear = -1;

    }
    // public function enqueue(string $value): void
    // {
    //     if ($value === "") {
    //         echo "Cannot enqueue an empty value.\n";
    //         return;
    //     }

    //     // If full, check if the oldest item timed out
    //     if (($this->rear + 1) % $this->size === $this->front) {
    //         $oldest = $this->queue[$this->front];
    //         if (time() - $oldest['timestamp'] > 5) {
    //             echo "Queue is full, but oldest item '{$oldest['value']}' timed out. Removing it.\n";
    //             $this->dequeue();
    //         }else {
                
    //         } 
    //     }

    //     if ($this->front === -1) {
    //         $this->front = 0;
    //     }
    //     $this->rear = ($this->rear + 1) % $this->size;
    //     $this->queue[$this->rear] = ['value' => $value, 'timestamp' => time()];

    //     echo "Enqueued: $value\n";
    // }

    public function enqueue(string $value): void
{
    if ($value === "") {
        echo "Cannot enqueue an empty value.\n";
        return;
    }

    // If full, check if the oldest item timed out
    // while (($this->rear + 1) % $this->size === $this->front) {
    //     $oldest = $this->queue[$this->front];
    //     $wait = 5 - (time() - $oldest['timestamp']);
    //     if ($wait > 0) {
    //         echo "Queue is full and oldest item '{$oldest['value']}' has not timed out. Waiting $wait seconds...\n";
    //         sleep($wait);
    //     } else {
    //         echo "Queue is full, but oldest item '{$oldest['value']}' timed out. Removing it.\n";
    //         $this->dequeue();
    //     }
    // }

    while (($this->rear + 1) % $this->size === $this->front) {
        // $oldest = $this->queue[$this->front];
        $wait = 5 - (time() - $this->queue[$this->front]['timestamp']); // 5-1=4, 5-2=3, 5-3=2, 5-4=1, 5-5=0
        if ($wait > 0) {
            echo "Queue is full \n";
            sleep(1);
        } else {
            echo "Queue is full, but oldest item was removed.\n";
            $this->dequeue();
        }
    }

    if ($this->front === -1) {
        $this->front = 0;
    }
    $this->rear = ($this->rear + 1) % $this->size;
    $this->queue[$this->rear] = ['value' => $value, 'timestamp' => time()];

    echo "Enqueued: $value\n";
}

    public function dequeue(): ?string
    {

        if ($this->front === -1) {
            echo "Queue is empty.\n";
            return null;
        }

        $item = $this->queue[$this->front];
        // var_dump($item);
        if (time() - $item['timestamp'] > 5) {
            echo "Item {$item['value']} timed out and removed.\n";
            // sleep(5); // Simulate waiting for 5 seconds before removings
            $this->front = ($this->front + 1) % $this->size;
            if ($this->front === ($this->rear + 1) % $this->size) {
                $this->front = $this->rear = -1; // Reset queue
            }
            return null;
        }

        $value = $item['value'];
        echo "Dequeued: $value\n";

        if ($this->front === $this->rear) {
            $this->front = $this->rear = -1; // Reset queue
        } else {
            $this->front = ($this->front + 1) % $this->size;
        }
        return $value;
    }

    public function display(): void
    {
        if ($this->front === -1) {
            echo "Queue is empty.\n";
            return;
        }
        // var_dump($this->queue);

        $i = $this->front;
        while (true) {
            echo " {$this->queue[$i]['value']}\n";
            if ($i === $this->rear) break;
            $i = ($i + 1) % $this->size;
        }
    }

}

$q = new circularQueueWithTiming(5);
$q->enqueue("A");

$q->enqueue("B");

$q->enqueue("C");

$q->enqueue("D");