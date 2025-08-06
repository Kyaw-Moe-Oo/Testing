<?php

require_once 'CustomerQueue.php'; // Assuming class from previous message

$q = new CustomerQueue();

// Setup queue
$q->addCustomer("A");
$q->addCustomer("B");
$q->addPriorityCustomer("VIP1");

// Track time for atomic 20s ticks
$startTime = time();
$lastCallTime = 0;

// Simulate script for 2 minutes
while (time() - $startTime < 120) {
    $now = time();

    // Atomically call callNext() every 20 seconds
    if (($now - $lastCallTime) >= 20) {
        echo "\n[⏱ AUTO CALL at " . date('H:i:s') . "]\n" . "<br>";;
        $q->callNext();
        $lastCallTime = $now;
    }

    // Simulate service logic
    if (($now - $startTime) === 22) {
        $q->completeService(); // finish VIP1
    }

    if (($now - $startTime) === 45) {
        echo "[⌛ Sleep simulation for A delay]\n" . "<br>";;
        sleep(65); // A doesn't show up, should be skipped
    }

    if (($now - $startTime) === 112) {
        $q->beginServiceForCalledCustomer(); // B shows up
        $q->completeService();
    }

    if (($now - $startTime) === 115) {
        $q->returnSkipped("A");
    }

    if (($now - $startTime) === 118) {
        $q->beginServiceForCalledCustomer(); // Serve A from returned queue
        $q->completeService();
        $q->showQueues();
    }

    sleep(1); // Avoid CPU spike
}