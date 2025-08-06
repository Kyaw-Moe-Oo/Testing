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
        'account_id' => 'A1003',
        'balance' => 12000,
        'interest_type' => 'compound',
        'rate' => 0.05,
        'compounding' => 'weekly',
        'start_date' => '2024-01-01',
        'end_date' => '2024-12-31',
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

$holidays = [
    '2023-06-21',
    '2023-07-04',
    '2023-08-25',
    '2023-08-29',

];

foreach ($accounts as $account) {
    $start = new DateTime($account['start_date']);
    $end = new DateTime($account['end_date']);
    $balance = $account['balance'];
    $annualRate = $account['rate'];

    if ($account['interest_type'] === 'compound' && $account['compounding'] === 'monthly') {

        $interval = $start->diff($end);
        $months = ($interval->y * 12) + $interval->m + 1;
        $periodRate = $annualRate / 12;
        $futureValue = $balance * pow((1 + $periodRate), $months);
        $interest = $futureValue - $balance;
        $tax = $interest * $account['rate'];
        $paidTaxInterest = $interest - $tax;
        echo "Account {$account['account_id']}<br>";
        echo "Compound Interest (Monthly): " . number_format($interest, 2) . "<br>";
        echo "Tax Price  (Monthly): " . number_format($tax, 2) . "<br>";
        echo "Compound Interest already paid tax (Monthly Tax): " . number_format($paidTaxInterest, 2) . "<br><br>";
    } else if (
        $account['interest_type'] === 'compound' &&
        $account['compounding'] === 'weekly'
    ) {
        $days = $start->diff($end)->days + 1;
        $weeks = floor($days / 7);
        $periodRate = $annualRate / 52;
        $futureValue = $balance * pow((1 + $periodRate), $weeks);
        $interest = $futureValue - $balance;
        $tax = $interest * $account['rate'];
        $paidTaxInterest = $interest - $tax;
        echo "Account {$account['account_id']}<br>";
        echo "Compound Interest (Weekly): " . number_format($interest, 2) . "<br>";
        echo "Tax Price  (Weekly): " . number_format($tax, 2) . "<br>";
        echo "Compound Interest already paid tax  (Weekly Tax): " . number_format($paidTaxInterest, 2) . "<br><br>";
    } else {
        $workingDays = countWorkingDays($start, $end, $holidays);
        $yearProportion = $workingDays / 365;
        $effectiveRate = $annualRate * $yearProportion;
        $interest = $balance * $effectiveRate;
        $tax = $interest * $account['rate'];
        $paidTaxInterest = $interest - $tax;

        echo "Account {$account['account_id']}<br>";
        echo "Simple Interest (working days only): " . number_format($interest, 2) . "<br>";
        echo "Tax Price  (Daily): " . number_format($tax, 2) . "<br>";
        echo "Compound Interest already paid tax  (Daily Tax): " . number_format($paidTaxInterest, 2) . "<br><br>";
    }
}


function countWorkingDays($start,  $end, array $holidays = []): int
{
    $workingDays = 0;
    $current =  $start;

    while ($current <= $end) {
        $dayOfWeek = (int)$current->format('N');
        $dateStr = $current->format('Y-m-d');

        if ($dayOfWeek <= 5 &&  !in_array($dateStr, $holidays)) {
            $workingDays++;
        }
        $current->modify('+1 day');
    }

    return $workingDays;
}