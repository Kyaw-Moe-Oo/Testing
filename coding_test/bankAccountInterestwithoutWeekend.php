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
function isWeekend(DateTime $date): bool{
    return $date->format('N') >=6;
}
function businessDaysBetween(DateTime $start, DateTime $end): int{
    $businessdays = 0;
    $current = clone $start;
    while($current<=$end){
        if (!isWeekend($current)) {
            $businessdays++;
        }
        $current->modify('+1 day');
    }
    return $businessdays;
}
function calculateInterest(array $accounts): float {
    $start =new DateTime($accounts['start_date']);
    $end = new DateTime($accounts['end_date']);
    $balance = $accounts['balance'];
    $rate = $accounts['rate'];
    if($accounts['interest_type'] === 'simple') {
        $businessdays = businessDaysBetween($start, $end);
        $interest = $balance * $rate * ($businessdays / 365);
        return $interest;
    }
    $n = match($accounts['compounding']) {
        'daily' => 365,
        'weekly' => 52,
        'monthly' => 12,
        'yearly' => 1
    };
    $totalPeriods = match($accounts['compounding']) {
        'daily' => businessDaysBetween($start, $end),
        'weekly' => businessDaysBetween($start, $end) / 5,
        'monthly' => ($end->format('Y') - $start->format('Y')) * 12 
                    + ($end->format('m') - $start->format('m'))
                    + 1,
        'yearly' => ($end->format('Y') - $start->format('Y')) + 1
    };
    $T = $totalPeriods / $n;
    $A = $balance * pow(1 + $rate / $n, $n * $T);
    $interest = $A - $balance;
    return $interest;
}
foreach($accounts as $account) {
    $interest = calculateInterest($account);
    echo "For account {$account['account_id']} is " . round($interest,2) ."<br>";
}
?>