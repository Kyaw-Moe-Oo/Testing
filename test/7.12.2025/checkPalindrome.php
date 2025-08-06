<?php
class InputRestrictedDeque
{
    private array $queue;
    private bool $caseSensitive;

    public function __construct(bool $caseSensitive = true)
    {
        $this->queue = [];
        $this->caseSensitive = $caseSensitive;
    }

    public function insertRear($value): void
    {
        array_push($this->queue, $value);
    }

    public function deleteFront()
    {
        return !empty($this->queue) ? array_shift($this->queue) : null;
    }

    public function deleteRear()
    {
        return !empty($this->queue) ? array_pop($this->queue) : null;
    }

    public function isPalindrome(): bool
    {
        $left = 0;
        $right = count($this->queue) - 1;

        while ($left < $right) {
            $leftVal = $this->queue[$left];
            $rightVal = $this->queue[$right];

            if (!$this->caseSensitive) {
                $leftVal = strtolower($leftVal);
                $rightVal = strtolower($rightVal);
            }

            if ($leftVal !== $rightVal) {
                echo "The queue is NOT a palindrome.\n";
                return false;
            }

            $left++;
            $right--;
        }

        echo "The queue is a palindrome.\n";
        return true;
    }

    public function display(): void
    {
        print_r($this->queue);
    }
}

//  Test 1: Case-Sensitive
echo "Test 1 (Case-Sensitive):\n";
$queue1 = new InputRestrictedDeque(true);
$queue1->insertRear('A');
$queue1->insertRear('b');
$queue1->insertRear('C');
$queue1->insertRear('B');
$queue1->insertRear('a');
$queue1->display();
$queue1->isPalindrome();

echo "\n";

//  Test 2: Case-Insensitive
echo "Test 2 (Case-Insensitive):\n";
$queue2 = new InputRestrictedDeque(false);
$queue2->insertRear('A');
$queue2->insertRear('b');
$queue2->insertRear('C');
$queue2->insertRear('B');
$queue2->insertRear('a');
$queue2->display();
$queue2->isPalindrome();
