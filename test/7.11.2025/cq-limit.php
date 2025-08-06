<?php

class CircularQueue {
    private $queue = [];
    private $timestamps = [];
    private $limit;

    public function __construct($limit) {
        $this->limit = $limit;
    }

    public function enqueue($value) {
        if (count($this->queue) < $this->limit) {

            $this->queue[] = $value;

            $this->timestamps[] = date('H:i:s');

        } else {
            echo "Queue full. Waiting 5 seconds...\n";
            sleep(5);

            $oldestIndex = $this->getOldestIndex();

            echo "Removing oldest: {$this->queue[$oldestIndex]} (at index $oldestIndex)\n";

           
            array_splice($this->queue, $oldestIndex, 1);
            array_splice($this->timestamps, $oldestIndex, 1);

           
            array_unshift($this->queue, $value);
            array_unshift($this->timestamps, date('H:i:s'));
        }
    }

    private function getOldestIndex(): int {
        $oldestIndex = 0;
        $oldestTime = strtotime($this->timestamps[0]);
        foreach ($this->timestamps as $i => $time) {
            if (strtotime($time) < $oldestTime) {
                $oldestTime = strtotime($time);
                $oldestIndex = $i;
            }
        }
        return $oldestIndex;
    }

    public function display() {
        echo "Current Queue:\n";
        foreach ($this->queue as $i => $value) {
            echo "[$i] Value: $value, Time: {$this->timestamps[$i]}\n";
        }
    }
    function IsPalindrone(string  $str) : bool {
        $cleanStr = preg_replace('/[^A-Za-z0-9]/','', $str);
        $cleanStr = strtolower($cleanStr);
        $left = 0;
        $right = strlen($cleanStr) - 1;
        while ($left < $right) {
            if ($cleanStr[$left] !== $cleanStr[$right]) {
                return false;
            }
            $left++;
            $right--;
        }
        return true;
    }
}


$q = new CircularQueue(3);

$q->enqueue(1);
$q->enqueue(2);
$q->enqueue(3);
$q->display();  // [1,2,3]

$q->enqueue(4);    // [4,2,3]
$q->display();

$q->enqueue(5);    //[5,4,2]
$q->display();
$q->IsPalindrone();