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
        'country' => 'DE', // Germany

        // Interest tiers
        'tiers' => [
            ['up_to' => 10000, 'rate' => 0.03],//3%
            ['up_to' => 20000, 'rate' => 0.05],//5%
            ['up_to' => null,  'rate' => 0.07],//7%
        ],

        // Seasonal adjustments to rates
        'seasonal_rates' => [
            ['from' => '2023-06-01', 'to' => '2023-08-31', 'rate_modifier' => 0.01],  // Summer boost
            ['from' => '2023-12-01', 'to' => '2023-12-31', 'rate_modifier' => -0.005], // Year-end adjustment
        ],

        // Penalties and bonuses
        'penalties' => [
            'early_withdrawal' => 0.02 // 2% of withdrawal if before end_date
        ],
        'bonuses' => [
            'loyalty_bonus' => [
                'after_months' => 12,
                'rate_boost' => 0.01
            ]
        ],

        // Account type and risk
        'account_type' => 'savings',
        'risk_profile' => 'low',

        // Compliance
        'compliance_flags' => [
            'high_volume_txns' => false,
            'large_foreign_deposits' => false,
        ],

        // FX hedge
        'fx_hedging' => [
            'enabled' => true,
            'hedge_rate' => 1.12 // lock-in conversion rate
        ],

        // Interest caps
        'interest_cap' => 1500,   // max yearly interest
        'interest_floor' => 0,    // no negative interest

        // KYC and customer
        'account_holder' => [
            'name' => 'Max Mustermann',
            'dob' => '1985-06-01',
            'nationality' => 'DE',
            'residency' => 'DE',
            'kyc_status' => 'verified'
        ],

        // Tax brackets
        'tax_brackets' => [
            ['up_to' => 1000, 'rate' => 0.10],
            ['up_to' => 5000, 'rate' => 0.20],
            ['up_to' => null, 'rate' => 0.30]
        ],

        // Transactions
        'transactions' => [
            ['date' => '2023-01-10', 'type' => 'deposit', 'amount' => 10000],
            ['date' => '2023-04-15', 'type' => 'deposit', 'amount' => 10000],
            ['date' => '2023-09-20', 'type' => 'withdrawal', 'amount' => 5000],
        ],

        // Associated Bank
        'bank' => [
            'id' => 'BANK001',
            'name' => 'Global Bank',
            'country' => 'DE',
            'regulatory_tier' => 'Tier 1'
        ]
    ],

    // You can define more accounts below similarly with variations
];

// Array
// (
//     [account_id] => A1001
//     [gross_interest] => 1450.32
//     [tax_paid] => 347.06
//     [net_interest] => 1103.26
//     [net_interest_usd] => 1235.65
//     [final_balance] => 31103.26
// )
function calculateInterestForAccounts($accounts) {
    $results = [];

    foreach ($accounts as $account) {
        $balance = $account['balance'];
        $startDate = new DateTime($account['start_date']);
        $endDate = new DateTime($account['end_date']);
        $days = $startDate->diff($endDate)->days;

        $interestAccrued = 0;
        $currentBalance = $balance;

        // Sort tiers lowest to highest
        usort($account['tiers'], fn($a, $b) => ($a['up_to'] ?? INF) <=> ($b['up_to'] ?? INF));

        // Map transactions by date
        $txMap = [];
        foreach ($account['transactions'] as $tx) {
            $txMap[$tx['date']][] = $tx;
        }

        // Loyalty bonus
        $loyaltyBoost = 0;
        if ((new DateTime($account['start_date']))->diff($endDate)->m >= 12 && isset($account['bonuses']['loyalty_bonus'])) {
            $loyaltyBoost = $account['bonuses']['loyalty_bonus']['rate_boost'];
        }

        // Daily compound interest calculation
        $currentDate = clone $startDate;
        for ($i = 0; $i <= $days; $i++) {
            $dateStr = $currentDate->format('Y-m-d');

            // Apply transactions on this date
            if (isset($txMap[$dateStr])) {
                foreach ($txMap[$dateStr] as $tx) {
                    $currentBalance += ($tx['type'] === 'deposit') ? $tx['amount'] : -$tx['amount'];
                }
            }

            // Base rate based on tier
            $rate = 0;
            foreach ($account['tiers'] as $tier) {
                if ($tier['up_to'] === null || $currentBalance <= $tier['up_to']) {
                    $rate = $tier['rate'];
                    break;
                }
            }

            // Apply seasonal rate modifiers
            foreach ($account['seasonal_rates'] as $season) {
                if ($dateStr >= $season['from'] && $dateStr <= $season['to']) {
                    $rate += $season['rate_modifier'];
                }
            }

            // Apply loyalty bonus
            $rate += $loyaltyBoost;

            // Daily compound
            $dailyInterest = $currentBalance * ($rate / 365);
            $interestAccrued += $dailyInterest;
            $currentBalance += $dailyInterest;

            $currentDate->modify('+1 day');
        }

        // Apply interest cap and floor
        $interestAccrued = min($account['interest_cap'], $interestAccrued);
        $interestAccrued = max($account['interest_floor'], $interestAccrued);

        // Tax calculation
        $taxPaid = 0;
        $remaining = $interestAccrued;
        foreach ($account['tax_brackets'] as $bracket) {
            $limit = $bracket['up_to'] ?? INF;
            $taxable = min($remaining, $limit);
            $taxPaid += $taxable * $bracket['rate'];
            $remaining -= $taxable;
            if ($remaining <= 0) break;
        }

        // Net interest
        $netInterest = $interestAccrued - $taxPaid;

        // FX hedge
        $netInterestUSD = $netInterest;
        if ($account['fx_hedging']['enabled']) {
            $netInterestUSD *= $account['fx_hedging']['hedge_rate'];
        }

        // Final balance
        $finalBalance = $balance + $netInterest;

        // Store formatted result
        $results[] = [
            'account_id'       => $account['account_id'] . "<br>",
            'gross_interest'   => round($interestAccrued, 2) . "<br>",
            'tax_paid'         => round($taxPaid, 2) . "<br>",
            'net_interest'     => round($netInterest, 2) . "<br>",
            'net_interest_usd' => round($netInterestUSD, 2) . "<br>",
            'final_balance'    => round($finalBalance, 2) . "<br>",
        ];
    }

    return $results;
}

// Example usage
$results = calculateInterestForAccounts($accounts);
print_r($results[0]); // print first account result
?>