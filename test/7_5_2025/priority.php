<?php

class CallQueue {
    private $queue = [];
    private $skipped = [];

    public function __construct($items) {
        if (!is_array($items)) {
            throw new Exception("Dataset must be an array!");
        }
        $this->queue = $items;
    }
    public function getSkipped() {
    return $this->skipped;
}

    // Try to call next in queue
    public function processNext() {
        if (empty($this->queue)) {
            echo "[" . date("H:i:s") . "] Queue is empty.\n";
            return;
        }
        $current = array_shift($this->queue);
        echo "[" . date("H:i:s") . "] Calling: $current\n";

        // Simulate response: random fail or success
        $responded = rand(0, 1);

        if ($responded) {
        echo "[" . date("H:i:s") . "]  $current responded.\n";
        } else {
            echo "[" . date("H:i:s") . "]  $current did not respond, skipping.\n";
            $this->skipped[] = $current;
        }
    }

    // When a skipped number comes back, put it at front
    public function returnSkipped($number) {
        $key = array_search($number, $this->skipped);
        if ($key === false) {
             echo "[" . date("H:i:s") . "]  $number was not skipped.\n";
            return;
        }

        unset($this->skipped[$key]);
        array_unshift($this->queue, $number);
         echo "[" . date("H:i:s") . "]  $number returned and added to front of queue.\n";
    }
    

    public function showStatus() {
        echo "[" . date("H:i:s") . "] Queue: [" . implode(", ", $this->queue) . "]\n";
        echo "[" . date("H:i:s") . "] Skipped: [" . implode(", ", $this->skipped) . "]\n";
    }
}

try {
    $queue = new CallQueue(range(1, 10));

    // Simulate calling every minute:
    for ($i = 0; $i < 12; $i++) {
        $queue->processNext();
        sleep(1); // Simulate 1 second instead of 1 minute
        $queue->showStatus();

        // Randomly return a skipped number
       $skipped = $queue->getSkipped();
if (!empty($skipped) && rand(0, 1)) {
    $returnNum = $skipped[array_rand($skipped)];
    $queue->returnSkipped($returnNum);
    $queue->showStatus();
}


        echo "-------------------------\n" . "<br>";
        sleep(1);
    }
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n" . "<br>";
}
