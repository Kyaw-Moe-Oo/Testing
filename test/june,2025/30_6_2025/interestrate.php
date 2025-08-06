<?php
$accounts = [
    [
        'account_id' => 'A1001',
        'balance' => 30000,
        'start_date' => '2023-01-01',
        'end_date' => '2023-12-31',
        'interest_type' => 'compound',
        'compounding' => 'daily',
        'currency' => 'EUR',
        'country' => 'DE',
        'tiers' => [
            ['up_to' => 10000, 'rate' => 0.03],
            ['up_to' => 20000, 'rate' => 0.05],
            ['up_to' => null,  'rate' => 0.07],
        ]
    ],
];

$exchangeRates = [
    'EUR' => 1.1,
    'USD' => 1.0
];

$taxRates = [
    'DE' => 0.25,
    'US' => 0.15
];

$holidaysByCountry = [
    'DE' => ['2023-01-01', '2023-12-25'],
    'US' => ['2023-07-04', '2023-12-25']
];

// Main Execution
foreach ($accounts as $account) {
    processAccount($account, $exchangeRates, $taxRates, $holidaysByCountry);
}

function processAccount(array $account, array $exchangeRates, array $taxRates, array $holidaysByCountry): void {
    $start = new DateTime($account['start_date']);
    $end = new DateTime($account['end_date']);
    $balance = $account['balance'];
    $currency = $account['currency'];
    $country = $account['country'];
    $holidays = $holidaysByCountry[$country] ?? [];
    $taxRate = $taxRates[$country] ?? 0.0;
    $tiers = $account['tiers'];
    $compounding = $account['compounding'];

    $days = countWorkingDays($start, $end, $holidays);
    $totalInterest = calculateTieredCompoundInterest($balance, $tiers, $days, $compounding);
    $tax = $totalInterest * $taxRate;
    $netInterest = $totalInterest - $tax;

    $exchangeRate = $exchangeRates[$currency] ?? 1.0;
    $grossUSD = $totalInterest * $exchangeRate;
    $netUSD = $netInterest * $exchangeRate;

    outputResult($account['account_id'], $currency, $exchangeRate, $totalInterest, $tax, $netInterest, $netUSD, $country);
}

function calculateTieredCompoundInterest(float $balance, array $tiers, int $days, string $compounding): float {
    $remaining = $balance;
    $totalInterest = 0;

    foreach ($tiers as $tier) {
        if ($remaining <= 0) break;

        $tierLimit = $tier['up_to'] ?? $balance;
        $applicable = min($remaining, $tierLimit - ($balance - $remaining));
        $periodRate = getPeriodRate($tier['rate'], $compounding);

        $futureValue = $applicable * pow(1 + $periodRate, $days);
        $interest = $futureValue - $applicable;

        $totalInterest += $interest;
        $remaining -= $applicable;
    }

    return $totalInterest;
}

function getPeriodRate(float $annualRate, string $compounding): float {
    return match ($compounding) {
        'daily' => $annualRate / 365,
        'weekly' => $annualRate / 52,
        'monthly' => $annualRate / 12,
        'yearly' => $annualRate,
        default => 0
    };
}

function countWorkingDays(DateTime $start, DateTime $end, array $holidays): int {
    $workingDays = 0;
    $current = clone $start;

    while ($current <= $end) {
        $day = $current->format('N'); // 1=Mon, ..., 7=Sun
        $dateStr = $current->format('Y-m-d');
        if ($day <= 5 && !in_array($dateStr, $holidays)) {
            $workingDays++;
        }
        $current->modify('+1 day');
    }

    return $workingDays;
}

function outputResult(
    string $accountId,
    string $currency,
    float $exchangeRate,
    float $gross,
    float $tax,
    float $net,
    float $netUSD,
    string $country
): void {
    echo "Account: $accountId ($country)<br>";
    echo "Currency: $currency (1 $currency = $exchangeRate USD)<br>";
    echo "Gross Interest: " . number_format($gross, 2) . " $currency<br>";
    echo "Tax: " . number_format($tax, 2) . " $currency<br>";
    echo "Net Interest: " . number_format($net, 2) . " $currency<br>";
    echo "Net Interest in USD: $" . number_format($netUSD, 2) . "<br><br>";
}
