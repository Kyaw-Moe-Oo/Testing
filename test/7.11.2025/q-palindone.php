<?php

class CircularDequeWithTiming {
    private array $queue;
    private int $size;
    private int $front;
    private int $rear;

    public function __construct(int $size) {
        $this->size = $size;
        $this->queue = array_fill(0, $size, null);
        $this->front = -1;
        $this->rear = -1;
    }

    private function isFull(): bool {
        return ($this->rear + 1) % $this->size === $this->front;
    }

    private function isEmpty(): bool {
        return $this->front === -1;
    }

    public function enqueueRear(string $value): void {
        while ($this->isFull()) {
            $wait = 5 - (time() - $this->queue[$this->front]['timestamp']);
            if ($wait > 0) {
                echo "Queue full (rear), waiting...\n";
                sleep(1);
            } else {
                echo "Timeout at front. Removing front.\n";
                $this->dequeueFront();
            }
        }

        if ($this->isEmpty()) {
            $this->front = $this->rear = 0;
        } else {
            $this->rear = ($this->rear + 1) % $this->size;
        }

        $this->queue[$this->rear] = ['value' => $value, 'timestamp' => time()];
        echo "Enqueued at rear: $value\n";
    }

    public function enqueueFront(string $value): void {
        while ($this->isFull()) {
            $wait = 5 - (time() - $this->queue[$this->rear]['timestamp']);
            if ($wait > 0) {
                echo "Queue full (front), waiting...\n";
                sleep(1);
            } else {
                echo "Timeout at rear. Removing rear.\n";
                $this->dequeueRear();
            }
        }

        if ($this->isEmpty()) {
            $this->front = $this->rear = 0;
        } else {
            $this->front = ($this->front - 1 + $this->size) % $this->size;
        }

        $this->queue[$this->front] = ['value' => $value, 'timestamp' => time()];
        echo "Enqueued at front: $value\n";
    }

    public function dequeueFront(): ?string {
        if ($this->isEmpty()) {
            echo "Queue empty.\n";
            return null;
        }

        $item = $this->queue[$this->front];
        if (time() - $item['timestamp'] > 5) {
            echo "Front item '{$item['value']}' timed out.\n";
        } else {
            echo "Dequeued front: {$item['value']}\n";
        }

        $value = $item['value'];
        if ($this->front === $this->rear) {
            $this->front = $this->rear = -1;
        } else {
            $this->front = ($this->front + 1) % $this->size;
        }

        return $value;
    }

    public function dequeueRear(): ?string {
        if ($this->isEmpty()) {
            echo "Queue empty.\n";
            return null;
        }

        $item = $this->queue[$this->rear];
        if (time() - $item['timestamp'] > 5) {
            echo "Rear item '{$item['value']}' timed out.\n";
        } else {
            echo "Dequeued rear: {$item['value']}\n";
        }

        $value = $item['value'];
        if ($this->front === $this->rear) {
            $this->front = $this->rear = -1;
        } else {
            $this->rear = ($this->rear - 1 + $this->size) % $this->size;
        }

        return $value;
    }

    public function display(): void {
        if ($this->isEmpty()) {
            echo "Queue is empty.\n";
            return;
        }

        echo "Queue: ";
        $i = $this->front;
        while (true) {
            echo $this->queue[$i]['value'] . " ";
            if ($i === $this->rear) break;
            $i = ($i + 1) % $this->size;
        }
        echo "\n";
    }

    // Palindrome check (only values)
public function isPalindrome(): bool {
    if ($this->isEmpty()) return true;

    $length = $this->size;
    $i = $this->front;
    $j = $this->rear;

    while (true) {
        if ($this->queue[$i]['value'] !== $this->queue[$j]['value']) {
            return false;
        }

        if ($i === $j || ($i + 1) % $length === $j) {
            break;
        }

        $i = ($i + 1) % $length;
        $j = ($j - 1 + $length) % $length;
    }

    return true;
}

}

$q = new CircularDequeWithTiming(7);

$q->enqueueRear("m");
$q->enqueueRear("a");
$q->enqueueRear("d");
$q->enqueueRear("a");
$q->enqueueRear("m");

$q->display();
$q->enqueueFront("k");

$q->display();

echo $q->isPalindrome() ? "Palindrome \n" : "Not Palindrome \n";
// $q->dequeueFront();
// $q->enqueueFront("x");
// $q->display();

// echo $q->isPalindrome() ? "Palindrome \n" : "Not Palindrome \n";
