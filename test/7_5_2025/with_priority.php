<?php

class CustomerQueue
{
    private array $queue = [];             // Normal queue
    private array $vipQueue = [];          // VIP priority queue
    private array $skipped = [];
    private array $returnedQueue = [];
    private ?array $currentlyServing = null;

    public function addCustomer(string $name, bool $isVip = false): void
    {
        $customer = ['name' => $name];
        if ($isVip) {
            $this->vipQueue[] = $customer;
        } else {
            $this->queue[] = $customer;
        }
    }

    public function callNext(): ?string
    {
        if ($this->currentlyServing) {
            echo "Still serving: {$this->currentlyServing['name']}\n";
            return null;
        }

        // 1. Serve returned customers first
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

        // 2. Serve VIP customers
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

        // 3. Handle normal queue
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

    public function completeService(): void
    {
        if ($this->currentlyServing) {
            echo "Finished serving: {$this->currentlyServing['name']}\n";
            $this->currentlyServing = null;
        }
    }

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
}

// Example usage
$q = new CustomerQueue();
$q->addCustomer("A");
$q->addCustomer("B");
$q->addCustomer("C");
$q->addCustomer("D");
$q->addCustomer("E", true); // VIP
$q->addCustomer("F", true); // VIP

// Simulate calling and serving
$q->callNext(); // Call VIP-1
sleep(1);
$q->completeService();
echo "<br>";

$q->callNext(); // Call VIP-2
$q->completeService();
echo "<br>";

$q->returnSkipped("E"); // Return VIP-1
echo "<br>";
$q->callNext(); // Call A
$q->completeService();
echo "<br>";

$q->callNext(); // Call B
$q->completeService();
echo "<br>";
 
$q->callNext(); // Serve returned C
$q->completeService();
echo "<br>";

$q->callNext(); // Call D
$q->completeService();
echo "<br>";

