<?php
$accounts = [
    [
        'originalRate' => 0.05,
        'balance' => 30000,
        'start_date' => '2023-01-01',
        'end_date' => '2023-12-31',
        'seasonal_rate' => [
            ['from' => '2023-06-01', 'to' => '2023-08-31', 'rate_modifier' => 0.01],
            ['from' => '2024-04-01', 'to' => '2024-08-31', 'rate_modifier' => 0.07],
            ['from' => '2023-12-01', 'to' => '2023-12-31', 'rate_modifier' => -0.005],
        ]
    ]
];

class InterestCalculator {
    private array $accounts;

    public function __construct(array $accounts) {
        $this->accounts = $accounts;
    }

    /**
     * Calculate the interest breakdown and total for all accounts.
     *
     * @return array Each account's monthly breakdown and total interest.
     */
    public function calculate(): array {
        $results = [];
        foreach ($this->accounts as $account) {
            $results[] = $this->calculateForAccount($account);
        }
        return $results;
    }

    /**
     * Calculate monthly interest breakdown and total for one account.
     *
     * @param array $account
     * @return array ['breakdown' => [...], 'total' => float, 'account' => array]
     */
    private function calculateForAccount(array $account): array {
        $originalRate = $account['originalRate'];
        $balance = $account['balance'];
        $startDate = new DateTime($account['start_date']);
        $endDate = new DateTime($account['end_date']);
        $seasonalRates = $account['seasonal_rate'] ?? [];

        $monthlyResults = [];
        $totalInterest = 0;
        $current = clone $startDate;

        while ($current <= $endDate) {
            $monthStart = new DateTime($current->format('Y-m-01'));
            $monthEnd = new DateTime($current->format('Y-m-t'));

            $modifier = $this->calculateMonthlyModifier($seasonalRates, $monthStart, $monthEnd);
            $finalRate = $originalRate + $modifier;
            $monthlyInterest = $balance * ($finalRate / 12);

            $monthlyResults[] = [
                'month' => $monthStart->format('F Y'),
                'rate_modifier' => round($modifier, 6),
                'final_rate' => round($finalRate, 6),
                'monthly_interest' => round($monthlyInterest, 2),
            ];

            $totalInterest += $monthlyInterest;
            $current->modify('first day of next month');
        }

        return [
            'account' => $account,
            'breakdown' => $monthlyResults,
            'total_interest' => round($totalInterest, 2),
        ];
    }

    /**
     * Calculate seasonal rate modifier weighted by overlap days in the month.
     *
     * @param array $seasonalRates
     * @param DateTime $monthStart
     * @param DateTime $monthEnd
     * @return float
     */
    private function calculateMonthlyModifier(array $seasonalRates, DateTime $monthStart, DateTime $monthEnd): float {
        $daysInMonth = (int)$monthStart->diff($monthEnd)->days + 1;
        $modifierTotal = 0.0;

        foreach ($seasonalRates as $season) {
            $seasonStart = new DateTime($season['from']);
            $seasonEnd = new DateTime($season['to']);

            $overlapStart = max($seasonStart, $monthStart);
            $overlapEnd = min($seasonEnd, $monthEnd);

            if ($overlapStart <= $overlapEnd) {
                $overlapDays = (int)$overlapStart->diff($overlapEnd)->days + 1;
                $modifierTotal += ($overlapDays / $daysInMonth) * $season['rate_modifier'];
            }
        }

        return $modifierTotal;
    }
}
$calculator = new InterestCalculator($accounts);
$results = $calculator->calculate();

// Display results nicely
foreach ($results as $result) {
    echo "Account with balance {$result['account']['balance']} and base rate {$result['account']['originalRate']}:\n" . "<br>";
    foreach ($result['breakdown'] as $monthData) {
        echo sprintf(
            "%s | Modifier: %.6f | Final Rate: %.6f | Interest: %.2f\n",
            $monthData['month'],
            $monthData['rate_modifier'],
            $monthData['final_rate'],
            $monthData['monthly_interest']
        );
        echo "<br>";
    }
    echo "Total Interest: {$result['total_interest']}\n";
    echo str_repeat('-', 40) . "\n";
}
?>