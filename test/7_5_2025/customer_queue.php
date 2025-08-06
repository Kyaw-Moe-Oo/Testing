<?php

class CustomerQueue
{
    private array $queue = [];
    private array $skipped = [];
    private array $returnedQueue = [];
    private ?array $currentlyServing = null;

    public function addCustomer(string $name): void
    {
        $this->queue[] = ['name' => $name];
    }

    public function callNext(): ?string
    {
        if ($this->currentlyServing) {
            echo "Still serving: {$this->currentlyServing['name']}\n";
            return null;
        }

        // Serve returned customers first
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

        // Handle normal queue
        while (!empty($this->queue)) {
            $customer = array_shift($this->queue);

            if (!isset($customer['called_at'])) {
                $customer['called_at'] = time();//10:48//10:51
                $this->currentlyServing = [
                    'name' => $customer['name'],//A,B
                    'status' => 'serving',
                    'called_at' => $customer['called_at']//10:48//10:51
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
$q->addCustomer("E");
$q->addCustomer("F");
// Simulate calling and serving
$q->callNext(); // Call A
sleep(1);       // A takes too long
$q->completeService();

$q->callNext(); // Skip A, Call B
$q->completeService();

$q->returnSkipped("A"); // A comes back
$q->callNext(); // Serve A
$q->completeService();

$q->callNext(); // Call C
$q->completeService();

?>