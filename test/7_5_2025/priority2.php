<?php

class CallQueue {
    private $queue = [];// main element holds in the queue
    private $skipped = [];//
    public function __construct($items) {
        if (!is_array($items)) {
            throw new Exception("Dataset must be an array!");
        }
        $this->queue = $items;
    }
    public function getSkipped() {
    return $this->skipped;
}
    public function processNext() {
        if (empty($this->queue)) {
            echo "[" . date("H:i:s") . "] Queue is empty.\n";
            return;
        }
        $current = array_shift($this->queue);
        echo "[" . date("H:i:s") . "] Calling: $current\n";
        $responded = rand(0, 1);// 1=>respond, 0=>skipped

        if ($responded) {
        echo "[" . date("H:i:s") . "]  $current responded.\n";
        } else {
            echo "[" . date("H:i:s") . "]  $current did not respond, skipping.\n";
            $this->skipped[] = $current;
        }
    }
    public function returnSkipped($number) {//1
        $key = array_search($number, $this->skipped);
        if ($key === false) {// If not found return false.
             echo "[" . date("H:i:s") . "]  $number was not skipped.\n";
            return;
        }
        unset($this->skipped[$key]);//If found remove the data from skipped 
        array_unshift($this->queue, $number);// puts it in front of the queue
         echo "[" . date("H:i:s") . "]  $number returned and added to front of queue.\n";
    }

    public function showStatus() {
        echo "[" . date("H:i:s") . "] Queue: [" . implode(", ", $this->queue) . "]\n";
        echo "[" . date("H:i:s") . "] Skipped: [" . implode(", ", $this->skipped) . "]\n";
    }
}
try {
    $queue = new CallQueue(range(1, 10));
    for ($i = 0; $i < 12; $i++) {
        $queue->processNext();
        sleep(1); // 1 second works
        $queue->showStatus();
       $skipped = $queue->getSkipped();
if (!empty($skipped) && rand(0, 1)) {
    $returnNum = $skipped[array_rand($skipped)];
    $queue->returnSkipped($returnNum);
    $queue->showStatus();
}
        // echo "-------------------------\n" . "<br>";
        sleep(1);
    }
} catch (Exception $e) {
    echo "Error: " ."<br>" . $e->getMessage() . "\n" . "<br>";
}