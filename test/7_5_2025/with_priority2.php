<?php

class CustomerQueue
{
    private array $queue = [];
    private array $vipQueue = [];
    private array $skipped = [];
    private array $returnedQueue = [];
    private ?array $currentlyServing = null;

    private const TIMEOUT = 20;         // Time allowed per attempt
    private const MAX_ATTEMPTS = 3;     // Max retries before skipping

    public function addCustomer(string $name, bool $isVip = false): void
    {
        $customer = [
            'name' => $name,
            'attempts' => 0,
        ];

        if ($isVip) {
            $this->vipQueue[] = $customer;
        } else {
            $this->queue[] = $customer;
        }
    }

    public function callNext(): ?string
    {
        if ($this->currentlyServing) {
            echo "Still serving: {$this->currentlyServing['name']}\n" . "<br>";
            return null;
        }

        // Returned customers first
        if (!empty($this->returnedQueue)) {
            $customer = array_shift($this->returnedQueue);
            $customer['called_at'] = time();
            $customer['attempts'] = 1;
            $this->currentlyServing = $customer;
            echo "Serving returned customer: {$customer['name']}\n" . "<br>";
            return $customer['name'];
        }

        // VIP queue
        $this->vipQueue = $this->processQueue($this->vipQueue, true);
        if ($this->currentlyServing) return $this->currentlyServing['name'];

        // Normal queue
        $this->queue = $this->processQueue($this->queue, false);
        if ($this->currentlyServing) return $this->currentlyServing['name'];

        echo "No customers to call.\n" . "<br>";
        return null;
    }

    private function processQueue(array $queue, bool $isVip): array
    {
        while (!empty($queue)) {
            $customer = array_shift($queue);
            $name = $customer['name'];

            if (!isset($customer['called_at'])) {
                // First time being called
                $customer['called_at'] = time();
                $customer['attempts'] = 1;
                $this->currentlyServing = $customer;
                echo ($isVip ? "Calling VIP: " : "Calling: ") . "$name\n" . "<br>";
                return $queue;
            }

            // Check if timeout exceeded
            if (time() - $customer['called_at'] > self::TIMEOUT) {
                $customer['attempts']++;

                if ($customer['attempts'] >= self::MAX_ATTEMPTS) {
                    echo " Skipped after 3 attempts: $name\n" . "<br>";
                    $customer['skipped_at'] = time();
                    $this->skipped[] = $customer;
                    continue;
                }

                // Retry the same customer
                echo " Retrying $name (attempt {$customer['attempts']})\n" . "<br>";
                $customer['called_at'] = time();
                $queue[] = $customer;
            } else {
                // Still within time limit — wait
                $queue[] = $customer;
            }
        }

        return $queue;
    }

    public function completeService(): void
    {
        if ($this->currentlyServing) {
            echo " Finished serving: {$this->currentlyServing['name']}\n" . "<br>";
            $this->currentlyServing = null;
        }
    }

    public function returnSkipped(string $name): void
    {
        foreach ($this->skipped as $index => $customer) {
            if ($customer['name'] === $name) {
                unset($this->skipped[$index]);
                $this->returnedQueue[] = [
                    'name' => $name,
                    'attempts' => 0
                ];
                echo " $name has returned to queue.\n" . "<br>";
                return;
            }
        }
        echo " $name was not found in skipped list.\n" . "<br>";
    }

    public function printSkipped(): void
    {
        if (empty($this->skipped)) {
            echo " No skipped customers.\n" . "<br>";
            return;
        }

        echo " Skipped Customers:\n" . "<br>";
        foreach ($this->skipped as $customer) {
            $name = $customer['name'];
            $attempts = $customer['attempts'];
            $ago = time() - ($customer['skipped_at'] ?? time());
            echo "- $name (after $attempts attempts, skipped $ago seconds ago)\n" . "<br>";
        }
    }
}

// ------------------- Usage -------------------

ini_set('max_execution_time', 300);

$q = new CustomerQueue();

// Add customers (normal & VIP)
$q->addCustomer("A");
$q->addCustomer("VIP-1", true);
$q->addCustomer("B");
$q->addCustomer("VIP-2", true);
$q->addCustomer("C");
$q->addCustomer("C");
$q->addCustomer("D");
$q->addCustomer("E", true); // VIP

// Simulate 10 calling cycles
for ($i = 1; $i <= 10; $i++) {
    echo "\n Cycle $i:\n";
    $q->callNext();

    // Simulate some delays: sleep 21s to force retry & skipping
    if (in_array($i, [3, 5, 6, 8, 9])) {
        sleep(21); // simulate non-response
    } else {
        sleep(2); // simulate normal response
    }

    $q->completeService();
}

// Print skipped customers
echo "\n Final Skipped List:\n" . "<br>";
$q->printSkipped();
