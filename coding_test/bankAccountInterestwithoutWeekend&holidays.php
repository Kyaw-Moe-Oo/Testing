<?php

// require 'vendor/autoload.php'; // Only include if you are using Composer dependencies

// Define the tax rate for interest in Myanmar (15%)
const TAX_RATE = 0.15;

$accounts = [
    [
        'account_id' => 'A1001',
        'balance' => 12000,
        'interest_type' => 'compound',
        'rate' => 0.05,
        'compounding' => 'yearly',
        'start_date' => '2023-01-01',
        'end_date' => '2023-12-31',
    ],
    [
        'account_id' => 'A1003',
        'balance' => 12000,
        'interest_type' => 'compound',
        'rate' => 0.05,
        'compounding' => 'monthly',
        'start_date' => '2023-01-01',
        'end_date' => '2023-12-31',
    ],
    [
        'account_id' => 'A1004',
        'balance' => 12000,
        'interest_type' => 'compound',
        'rate' => 0.05,
        'compounding' => 'weekly',
        'start_date' => '2023-01-01',
        'end_date' => '2023-12-31',
    ],
    [
        'account_id' => 'A1005',
        'balance' => 12000,
        'interest_type' => 'compound',
        'rate' => 0.05,
        'compounding' => 'daily',
        'start_date' => '2023-01-01',
        'end_date' => '2023-12-31',
    ],
    [
        'account_id' => 'A1002',
        'balance' => 5000,
        'interest_type' => 'simple',
        'rate' => 0.03,
        'compounding' => 'daily', // Compounding type is not directly used for simple interest but kept for consistency
        'start_date' => '2024-06-01',
        'end_date' => '2024-09-01',
    ]
];

function isWeekend(DateTime $date): bool{
    return $date->format('N') >=6;
}

function isPublicHoliday(DateTime $date, array $holidays): bool{
    return false;
}
function isBusinessDays(DateTime $date, array $publicHolidays): bool {
    return !isWeekend($date);
}
function businessDaysBetween(DateTime $start, DateTime $end, array $publicHolidays):int {
    $businessdays = 0;
    $current = clone $start;
    while ($current<=$end) {
        if (isBusinessDays($current, $publicHolidays)) {
            $businessdays++;
        }
        $current->modify('+1 day');
    }
    return $businessdays;
}
function getPublicHolidayForMyanmarYear(int $year): array {
    return [];
}
function getAllPublicHolidaysForMyanmarRange(DateTime $startDate, DateTime $endDate): array {
    return [];
}
function calculateInterest(array $account, array $publicHoliday): array {
    $start = new DateTime($account['start_date']);
    $end = new DateTime($account['end_date']);
    $balance = $account['balance'];
    $rate = $account['rate'];

    $grossInterest = 0;
    $totalDays = 0;
    $calculateDaysType = "";

    if($account['interest_type'] === 'simple') {
        $businessDays = businessDaysBetween($start, $end, $publicHoliday);
        $grossInterest = $balance * $rate * ($businessDays / 365);
        $totalDays = $businessDays;
        $calculateDaysType = "Business Days (excluding weekends)";
    }else if($account['interest_type'] === 'compound') {
        $n = match($account['compounding']) {
            'daily' => 365,
            'weekly' => 52,
            'monthly' => 12,
            'yearly' => 1,
            default => throw new InvalidArgumentException("Invalid compounding period: {$account['compounding']}")
        };
        $interval = $start->diff($end);
        $dayDifference = $interval->days;
        $totalDays = $dayDifference + 1;

        $t = $totalDays / 356;
        $A = $balance * pow(1 + $rate / $n, $n * $t);
        $grossInterest = $A - $balance;
        $calculateDaysType = "Total Calender Days";
    }else {
        throw new InvalidArgumentException("Invalid Interest Type: {$account['interest_type']}");
    }

    $TaxAmount = $grossInterest * TAX_RATE;
    $netInterest = $grossInterest - $TaxAmount;
    
    return [
        'gross_interest' => $grossInterest,
        'tax_amount' => $TaxAmount,
        'net_interest' => $netInterest,
        'days_calculated' => $totalDays,
        'days_type' => $calculateDaysType
    ];
}
foreach($accounts as $account) {
    $accountStartDate = new DateTime($account['start_date']);
    $accountEndDate = new DateTime($account['end_date']);

    $relevantHolidays = [];
    try{
        $results = calculateInterest($account, $relevantHolidays);
        echo "<h2>Account ID: {$account['account_id']}</h2>";
        echo "<ul>";
        echo "<li>Initial Balance: " . number_format($account['balance'], 2) . "</li>";
        echo "<li>Annual Interest Rate: " . ($account['rate'] * 100) . "%</li>";
        echo "<li>Interest Type: " . ucfirst($account['interest_type']) . "</li>";
        if ($account['interest_type'] === 'compound') {
            echo "<li>Compounding Period: " . ucfirst($account['compounding']) . "</li>";
        }
        echo "<li>Period: {$account['start_date']} to {$account['end_date']}</li>";
        echo "<li>Number of Days for Calculation ({$results['days_type']}): {$results['days_calculated']}</li>";
        echo "<li><strong>Gross Interest: " . number_format($results['gross_interest'], 2) . "</strong></li>";
        echo "<li>Tax Rate Applied: " . (TAX_RATE * 100) . "%</li>";
        echo "<li>Tax Amount: " . number_format($results['tax_amount'], 2) . "</li>";
        echo "<li><strong>Net Interest (After Tax): " . number_format($results['net_interest'], 2) . "</strong></li>";
        echo "</ul>";
        echo "<hr>"; // Separator for clarity

    } catch (InvalidArgumentException $e) {
        echo "<h2>Error for Account ID: {$account['account_id']}</h2>";
        echo "<p>Error: " . $e->getMessage() . "</p>";
        echo "<hr>";
    }
}

