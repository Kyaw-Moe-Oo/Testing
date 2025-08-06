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

foreach ($accounts as $account) {
    $start = new DateTime($account['start_date']);
    $end = new DateTime($account['end_date']);
    $balance = $account['balance'];
    $annualRate = $account['rate'];

    if ($account['interest_type'] === 'compound') {
        $compounding = $account['compounding'];
        $interval = $start->diff($end);
        $months = ($interval->y * 12) + $interval->m + 1;
        $periodRate = $annualRate / 12;
        $futureValue = $balance * pow((1 + $periodRate), $months);
        $interest = $futureValue - $balance;
        echo "Account {$account['account_id']}<br>";
        echo "Compound Interest (Monthly): " . number_format($interest, 2) . "<br><br>";
    } else {
        $weekdays = 0;
        $current =  $start;
        while ($current <= $end) {
            if ((int)$current->format('N') <= 5) {
                $weekdays++;
            }
            $current->modify('+1 day');
        }
        $yearProportion = $weekdays / 365;
        $effectiveRate = $annualRate * $yearProportion;
        $interest = $balance * $effectiveRate;

        echo "Account {$account['account_id']}<br>";
        echo "Simple Interest: " . number_format($interest, 2) . "<br><br>";
    }
}