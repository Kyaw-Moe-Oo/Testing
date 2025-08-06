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

function getTieredRate($balance, $tiers) {
    foreach ($tiers as $tier) {
        if ($tier['up_to'] === null || $balance <= $tier['up_to']) {
            return $tier['rate'];
        }
    }
    return 0;
}

function calculateCompoundDaily($balance, $rate, $days) {
    $dailyRate = $rate / 365;
    return $balance * (pow(1 + $dailyRate, $days) - 1);
}

foreach ($accounts as $account) {
    $start = new DateTime($account['start_date']);
    $end = new DateTime($account['end_date']);
    $days = $start->diff($end)->days + 1;

    $rate = getTieredRate($account['balance'], $account['tiers']);
    $interest = calculateCompoundDaily($account['balance'], $rate, $days);

    // Convert to USD
    $interestUSD = $interest * $exchangeRates[$account['currency']];

    // Tax
    $tax = $interestUSD * $taxRates[$account['country']];
    $netInterest = $interestUSD - $tax;

    echo "Account: {$account['account_id']}<br>";
    echo "Gross Interest (USD): " . number_format($interestUSD, 2) . "<br>";
    echo "Tax: " . number_format($tax, 2) . "<br>";
    echo "Net Interest (USD): " . number_format($netInterest, 2) . "<br><br>";
}
?>