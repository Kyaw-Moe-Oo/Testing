<?php

class CustomerQueue
{
    private array $queue = [];             // Normal queue
    private array $vipQueue = [];          // VIP priority queue
    private array $skipped = [];           // Customers skipped due to timeout
    private array $returnedQueue = [];     // Returned skipped customers
    private ?array $currentlyServing = null; // Current serving customer

    // Add customer (normal or VIP)
    public function addCustomer(string $name, bool $isVip = false): void
    {
        $customer = ['name' => $name];
        if ($isVip) {
            $this->vipQueue[] = $customer;
        } else {
            $this->queue[] = $customer;
        }
    }

    // Call the next customer
    public function callNext(): ?string
    {
        if ($this->currentlyServing) {
            echo "Still serving: {$this->currentlyServing['name']}\n";
            return null;
        }

        // 1. Returned customers first
        if (!empty($this->returnedQueue)) {
            $customer = array_shift($this->returnedQueue);
            $this->currentlyServing = [
                'name' => $customer['name'],
                'status' => 'serving',
                'called_at' => time()
            ];
            echo "Serving returned customer: {$customer['name']}\n";
            return $customer['name'];
        }

        // 2. VIP queue next
        while (!empty($this->vipQueue)) {
            $customer = array_shift($this->vipQueue);

            if (!isset($customer['called_at'])) {
                $customer['called_at'] = time();
                $this->currentlyServing = [
                    'name' => $customer['name'],
                    'status' => 'serving',
                    'called_at' => $customer['called_at']
                ];
                echo "Calling VIP: {$customer['name']}\n";
                return $customer['name'];
            }

            if (time() - $customer['called_at'] > 60) {
                echo "Skipped VIP: {$customer['name']}\n";
                $this->skipped[] = $customer;
            } else {
                $this->vipQueue[] = $customer;
            }
        }

        // 3. Normal queue last
        while (!empty($this->queue)) {
            $customer = array_shift($this->queue);

            if (!isset($customer['called_at'])) {
                $customer['called_at'] = time();
                $this->currentlyServing = [
                    'name' => $customer['name'],
                    'status' => 'serving',
                    'called_at' => $customer['called_at']
                ];
                echo "Calling: {$customer['name']}\n";
                return $customer['name'];
            }

            if (time() - $customer['called_at'] > 60) {
                echo "Skipped: {$customer['name']}\n";
                $this->skipped[] = $customer;
            } else {
                $this->queue[] = $customer;
            }
        }

        echo "No customers to call.\n";
        return null;
    }

    // Complete the current service
    public function completeService(): void
    {
        if ($this->currentlyServing) {
            echo "Finished serving: {$this->currentlyServing['name']}\n";
            $this->currentlyServing = null;
        }
    }

    // A skipped customer returns
    public function returnSkipped(string $name): void
    {
        foreach ($this->skipped as $index => $customer) {
            if ($customer['name'] === $name) {
                unset($this->skipped[$index]);
                $this->returnedQueue[] = ['name' => $name];
                echo "$name has returned to queue.\n";
                return;
            }
        }
        echo "$name was not found in skipped list.\n";
    }

    // View all skipped customers
    public function printSkipped(): void
    {
        if (empty($this->skipped)) {
            echo "No skipped customers.\n";
            return;
        }

        echo "Skipped Customers:\n";
        foreach ($this->skipped as $customer) {
            $name = $customer['name'];
            $calledAt = $customer['called_at'] ?? null;
            $timeAgo = $calledAt ? time() - $calledAt : 'unknown';

            echo "- $name (called " . ($timeAgo !== 'unknown' ? "$timeAgo seconds ago" : "unknown time") . ")\n";
        }
    }

    // (Optional) Get skipped customers as array
    public function getSkipped(): array
    {
        return $this->skipped;
    }
}

$q = new CustomerQueue();

// Add normal and VIP customers
$q->addCustomer("A");
$q->addCustomer("B");
$q->addCustomer("VIP-1", true); // VIP
$q->addCustomer("C");
$q->addCustomer("VIP-2", true); // VIP
$q->addCustomer("D");

// Call & complete in order
$q->callNext(); // VIP-1
$q->completeService();
echo "<br>";

$q->callNext(); // VIP-2
$q->completeService();
echo "<br>";

$q->callNext(); // A
sleep(2); // Wait 2 seconds
$q->completeService();
echo "<br>";

$q->callNext(); // B
sleep(1); // Simulate delay
$q->completeService();
echo "<br>";

$q->callNext(); // C
$q->completeService();
echo "<br>";

// Print skipped list
$q->printSkipped();
echo "<br>";

// Return a skipped customer
$q->returnSkipped("B");
echo "<br>";

// Serve returned customer
$q->callNext();
$q->completeService();
echo "<br>";

// Remaining
$q->callNext(); // D
$q->completeService();
echo "<br>";