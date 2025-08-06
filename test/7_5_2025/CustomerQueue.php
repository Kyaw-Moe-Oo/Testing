<?php

class CustomerQueue
{
    private array $queue = [];
    private array $priorityQueue = [];
    private array $returnedQueue = [];
    private array $skipped = [];
    private ?array $currentlyServing = null;

    // Add a regular customer
    public function addCustomer(string $name): void
    {
        $this->queue[] = ['name' => $name];
        echo "Customer $name added to the regular queue.\n" . "<br>";
    }

    // Add a priority customer
    public function addPriorityCustomer(string $name): void
    {
        $this->priorityQueue[] = ['name' => $name];
        echo "Priority customer $name added to the priority queue.\n" . "<br>";
    }

    // Call the next customer (one at a time)
    public function callNext(): ?string
    {
        $this->cleanupMissed();

        if ($this->currentlyServing) {
            echo "Still serving: {$this->currentlyServing['name']}\n" . "<br>";
            return null;
        }

        // 1. Priority queue (VIPs served immediately)
        if (!empty($this->priorityQueue)) {
            $customer = array_shift($this->priorityQueue);
            return $this->startServing($customer, 'priority');
        }

        // 2. Returned customers
        if (!empty($this->returnedQueue)) {
            $customer = array_shift($this->returnedQueue);
            return $this->startServing($customer, 'returned');
        }

        // 3. Regular queue
        if (!empty($this->queue)) {
            $customer = &$this->queue[0]; // reference first customer

            if (!isset($customer['called_at'])) {
                $customer['called_at'] = time();
                echo "Calling regular customer: {$customer['name']}\n" . "<br>";
            } elseif (time() - $customer['called_at'] > 60) {
                echo "Skipped (timeout): {$customer['name']}\n" . "<br>";
                $this->skipped[] = array_shift($this->queue); // remove from queue
                return $this->callNext(); // recursively check next
            } else {
                echo "Waiting for customer: {$customer['name']} (still within 60s)\n" . "<br>";
            }
        }

        echo "No available customers to serve.\n" . "<br>";
        return null;
    }

    // Customer arrives to be served (within time limit)
    public function beginServiceForCalledCustomer(): ?string
    {
        if ($this->currentlyServing) {
            echo "Already serving: {$this->currentlyServing['name']}\n" . "<br>";
            return null;
        }

        if (!empty($this->queue)) {
            $customer = $this->queue[0];
            if (isset($customer['called_at']) && time() - $customer['called_at'] <= 60) {
                $this->currentlyServing = [
                    'name' => $customer['name'],
                    'status' => 'serving',
                    'called_at' => $customer['called_at']
                ];
                array_shift($this->queue);
                echo "Customer has arrived. Now serving: {$customer['name']}\n" . "<br>";
                return $customer['name'];
            }
        }

        echo "No called customer is ready to be served.\n" . "<br>";
        return null;
    }

    // Finish current service
    public function completeService(): void
    {
        if ($this->currentlyServing) {
            echo "Finished serving: {$this->currentlyServing['name']}\n" . "<br>";
            $this->currentlyServing = null;
        } else {
            echo "No customer is currently being served.\n" . "<br>";
        }
    }

    // Return a previously skipped customer
    public function returnSkipped(string $name): void
    {
        foreach ($this->skipped as $index => $customer) {
            if ($customer['name'] === $name) {
                unset($this->skipped[$index]);
                $this->returnedQueue[] = ['name' => $name];
                echo "$name has returned and added to the returned queue.\n" . "<br>";
                return;
            }
        }

        echo "$name not found in skipped list.\n" . "<br>";
    }
    // Clean up customers who timed out
    private function cleanupMissed(): void
    {
        foreach ($this->queue as $i => $customer) {
            if (isset($customer['called_at']) && time() - $customer['called_at'] > 60) {
                echo "Auto-skip: {$customer['name']} (timeout)\n" . "<br>";
                $this->skipped[] = $customer;
                unset($this->queue[$i]);
            }
        }
        // Re-index to keep the array clean
        $this->queue = array_values($this->queue);
    }

    // Start serving the given customer
    private function startServing(array $customer, string $source): string
    {
        $this->currentlyServing = [
            'name' => $customer['name'],
            'status' => 'serving',
            'called_at' => time()
        ];
        echo "Now serving {$customer['name']} from $source queue.\n" . "<br>";
        return $customer['name'];
    }

    // Optional: Display current queue states
    public function showQueues(): void
    {
        echo "\n--- QUEUE STATUS ---\n";
        echo "Priority Queue: " . implode(', ', array_column($this->priorityQueue, 'name')) . "\n" . "<br>";
        echo "Regular Queue: " . implode(', ', array_column($this->queue, 'name')) . "\n" . "<br>";;
        echo "Returned Queue: " . implode(', ', array_column($this->returnedQueue, 'name')) . "\n" . "<br>";;
        echo "Skipped: " . implode(', ', array_column($this->skipped, 'name')) . "\n" . "<br>";;
        echo "Currently Serving: " . ($this->currentlyServing['name'] ?? 'None') . "\n" . "<br>";;
        echo "---------------------\n\n" . "<br>";;
    }
}