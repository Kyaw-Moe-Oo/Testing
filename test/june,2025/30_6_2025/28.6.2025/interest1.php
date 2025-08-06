<?php

$accounts = [
    [
        'account_id' => 'A1001',
        'balance' => 12000,
        'interest_type' => 'compound',
        'rate' => 0.05,
        'compounding' => 'monthly',
        'start_date' => '2023-01-01',
        'end_date' => '2023-12-31',
    ],
    [
        'account_id' => 'A1002',
        'balance' => 5000,
        'interest_type' => 'simple',
        'rate' => 0.03,
        'compounding' => 'daily',
        'start_date' => '2023-06-01',
        'end_date' => '2023-09-01',
    ]
];

function calculateAllInterests(array $accounts): array {
    $results = [];

    foreach ($accounts as $acc) {
        $start = new DateTime($acc['start_date']);
        $end = new DateTime($acc['end_date']);
        $balance = $acc['balance'];
        $rate = $acc['rate'];
        $type = $acc['interest_type'];
        $compounding = $acc['compounding'];

        $compoundMap = [
            'daily' => ['interval' => 'P1D', 'periods' => 365],
            'weekly' => ['interval' => 'P1W', 'periods' => 52],
            'monthly' => ['interval' => 'P1M', 'periods' => 12],
            'yearly' => ['interval' => 'P1Y', 'periods' => 1]
        ];

        $periodInfo = $compoundMap[$compounding] ?? $compoundMap['daily'];
        $interval = new DateInterval($periodInfo['interval']);
        $periodsPerYear = $periodInfo['periods'];

        $interest = 0;
        $current = clone $start;

        if ($type === 'simple') {
            $validDays = 0;
            while ($current <= $end) {
                if ((int)$current->format('N') < 6) {
                    $validDays++;
                }
                $current->add(new DateInterval('P1D'));
            }
            $interest = $balance * $rate * ($validDays / 365);
        } else {
            // compound
            while ($current <= $end) {
                if ((int)$current->format('N') < 6) {
                    $balance += $balance * ($rate / $periodsPerYear);
                }
                $current->add($interval);
            }
            $interest = $balance - $acc['balance'];
        }

        $results[] = [
            'account_id' => $acc['account_id'],
            'interest' => round($interest, 2),
            'final_balance' => round($acc['balance'] + $interest, 2)
        ];
    }

    return $results;
}

// Run and output
print_r(calculateAllInterests($accounts));
