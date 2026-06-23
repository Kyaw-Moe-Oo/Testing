<?php
const TAX_RATE  = 0.15;
$accounts = [
    [
        'account_id'  => 'A1001',
        'balance' => 12000,
        'interest_type' => 'compound',
        'compounding' => 'yearly',
        'rate' => 0.05,
        'start_date' => '2023-01-01',
        'end_date' => '2023-12-31'
    ],
    [
        'account_id'  => 'A1002',
        'balance' => 5000,
        'interest_type' => 'simple',
        'compounding' => 'daily',
        'rate' => 0.03,
        'start_date' => '2023-06-01',
        'end_date' => '2023-09-01'
    ]
];
function isWeekend(DateTime $date): bool {
    return $date->format('N') >= 6;
}
function isPublicHoliday(DateTime $date, array $holidays): bool {
    return false;
}
function isBusinessDays(DateTime $date, array $publicHolidays): bool {
    return !isWeekend($date);
}
function businessDaysBetween(DateTime $start, DateTime $end, array $publicHolidays): int {
    $businessDays = 0;
    $current = clone $start;
    while ($current <= $end) {
        if (isBusinessDays($current, $publicHolidays)) {
            $businessDays++;
        }
        $current->modify('+1 day');
    }
    return $businessDays;
}
function getPublicHolidaysForMyanmarYear(int $year): array {
    return [];
}
function getAllPublicHolidaysForMyanmayInRange(DateTime $startDate, DateTime $endDate): array {
    return [];
}
function calculateInterest(array $account, array $publicHolidays): array {
    $start = new DateTime($account['start_date']);
    $end = new DateTime($account['end_date']);
    $balance = $account['balance'];
    $rate = $account['rate'];

    $grossInterest = 0;
    $totalDays = 0;
    $calculatedDaysType = "";
    
    if ($account['interest_type'] === 'simple') {
        $businessDays = businessDaysBetween($start, $end, $publicHolidays);
        $grossInterest = $balance * $rate * ($businessDays / 365);
        $totalDays = $businessDays;
        $calculatedDaysType = "Business Days (excluding weekend)"; 
    }else if ($account['interest_type'] === 'compound') {
            $n = match($account['compounding']) {
            'daily' => 365,
            'weekly' => 52,
            'monthly' => 12,
            'yearly' => 1,
            default => throw new InvalidArgumentException("Invalid Compounding Periods : {$account['compounding']}")
        };
        $interval = $start->diff($end);
        $totalDays = $interval->days + 1;
        $T = $totalDays / 365;
        $A = $balance * pow(1 + $rate / $n, $n * $T);
        $grossInterest = $A - $balance;
        $calculatedDaysType = "Total Calendar Days";
    }else {
        throw new InvalidArgumentException("Invalid Interest type : {$account['interest_type']}");
    }
    $taxAmount = $grossInterest * TAX_RATE;
    $netInterest = $grossInterest - $taxAmount;
    
    return 
    [
        'tax_amount' => $taxAmount,
        'days_calculated' => $totalDays,
        'days_type' => $calculatedDaysType,
        'gross_interest' => $grossInterest,
        'net_interest' => $netInterest
    ];
}
foreach($accounts as $account) {
    $accountStartDate = new DateTime($account['start_date']);
    $accountEndDate = new DateTime($account['end_date']);
    $relenvantHolidays = [];
    try{
        $results = calculateInterest($account, $relenvantHolidays);
        echo "<h2>For Account ID : {$account['account_id']} </h2>";
        echo "<ul>";
        echo "<li>Initial Balance : " . number_format($account['balance'], 2) . "</li>";
        echo "<li>Innual Interest rate : " . ($account['rate'] * 100) . "%</li>";
        echo "<li>Interest Type : " . ucfirst($account['interest_type']) . "</li>";
        if ($account['interest_type'] === 'compound') {
            echo "<li>compounding Periods : " . ucfirst('compounding') . "</li>";
        }
        echo "<li>Period: {$account['start_date']} to {$account['end_date']} </li>";
        echo "<li>Number of Days for Calculations : {$results['days_type']} : {$results['days_calculated']} </li>";
        echo "<li><strong>Gross Interest : " . number_format($results['gross_interest'], 2) . "</strong></li>";
        echo "<li>Tax rate applied : " . (TAX_RATE *100) . "%</li>";
        echo "<li>Tax amount : " . number_format($results['tax_amount'], 2) . "</li>";
        echo "<li><strong>Net Interest : " . number_format($results['net_interest'], 2) . "</strong><?li>";
        echo "</ul>";
        echo "<hr>";
    }catch (InvalidArgumentException $e) {
        echo "<h2>Error for Account ID : {$account['account_id']} </h2>";
        echo "<p>Error : " . $e->getMessage() . "</p>";
        echo "<hr>";
    }
   
}

