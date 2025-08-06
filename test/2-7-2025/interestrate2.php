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
            ['up_to' => 10000, 'rate' => 0.03], // 3%
            ['up_to' => 20000, 'rate' => 0.05], // 5%
            ['up_to' => null,   'rate' => 0.07], // 7%
        ],

        // Seasonal adjustments to rates
        'seasonal_rates' => [
            ['from' => '2023-06-01', 'to' => '2023-08-31', 'rate_modifier' => 0.01],   // Summer boost
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
        'interest_cap' => 1500,    // max yearly interest
        'interest_floor' => 0,     // no negative interest

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

/**
 * Calculates the gross interest for an account based on its balance and interest tiers.
 * This is a simplified calculation, assuming annual compounding for tiered rates.
 * For true daily compounding, a more complex daily balance tracking would be needed.
 */
function calculateGrossInterest(array $account): float
{
    $balance = $account['balance'];
    $grossInterest = 0;

    foreach ($account['tiers'] as $tier) {
        $upTo = $tier['up_to'];
        $rate = $tier['rate'];

        if ($upTo === null || $balance <= $upTo) {
            $grossInterest += $balance * $rate;
            break;
        } else {
            $interestableAmount = ($upTo - ($grossInterest / $rate)); // Calculate the amount for this tier
            if ($grossInterest === 0) { // First tier
                $interestableAmount = $upTo;
            }
            $grossInterest += $interestableAmount * $rate;
            $balance -= $interestableAmount;
        }
    }

    // Apply seasonal adjustments (simplified for annual calculation)
    foreach ($account['seasonal_rates'] as $seasonalRate) {
        // In a real scenario, you'd calculate daily interest and apply modifiers
        // For this example, we'll just add a simplified annual impact
        if (isset($seasonalRate['rate_modifier'])) {
            $grossInterest += $account['balance'] * $seasonalRate['rate_modifier'] / 3; // Roughly for 3 months
        }
    }

    // Apply loyalty bonus (simplified for annual calculation)
    if (isset($account['bonuses']['loyalty_bonus'])) {
        $loyaltyBonus = $account['bonuses']['loyalty_bonus'];
        $startDate = new DateTime($account['start_date']);
        $endDate = new DateTime($account['end_date']);
        $interval = $startDate->diff($endDate);
        $months = $interval->y * 12 + $interval->m;

        if ($months >= $loyaltyBonus['after_months']) {
            $grossInterest += $account['balance'] * $loyaltyBonus['rate_boost'];
        }
    }

    // Apply interest cap
    if (isset($account['interest_cap']) && $grossInterest > $account['interest_cap']) {
        $grossInterest = $account['interest_cap'];
    }

    // Apply interest floor
    if (isset($account['interest_floor']) && $grossInterest < $account['interest_floor']) {
        $grossInterest = $account['interest_floor'];
    }

    return round($grossInterest, 2);
}

/**
 * Calculates the tax paid on gross interest based on tax brackets.
 */
function calculateTaxPaid(float $grossInterest, array $taxBrackets): float
{
    $taxPaid = 0;
    $remainingInterest = $grossInterest;

    foreach ($taxBrackets as $bracket) {
        $upTo = $bracket['up_to'];
        $rate = $bracket['rate'];

        if ($upTo === null || $remainingInterest <= $upTo) {
            $taxPaid += $remainingInterest * $rate;
            break;
        } else {
            $taxableAmount = $upTo;
            if ($taxPaid > 0) { // If it's not the first bracket, calculate the amount within this bracket
                $taxableAmount = $upTo - ($grossInterest - $remainingInterest);
            }
            $taxPaid += $taxableAmount * $rate;
            $remainingInterest -= $taxableAmount;
        }
    }
    return round($taxPaid, 2);
}

/**
 * Processes a single account to calculate interest, tax, and final balance.
 */
function processAccount(array $account): array
{
    $grossInterest = calculateGrossInterest($account);
    $taxPaid = calculateTaxPaid($grossInterest, $account['tax_brackets']);
    $netInterest = $grossInterest - $taxPaid;
    $finalBalance = $account['balance'] + $netInterest;

    $netInterestUsd = 0;
    if (isset($account['fx_hedging']['enabled']) && $account['fx_hedging']['enabled'] === true) {
        $netInterestUsd = $netInterest * $account['fx_hedging']['hedge_rate'];
    } else {
        // For simplicity, if hedging is not enabled, we'll just use a fixed rate.
        // In a real scenario, you'd fetch the current exchange rate.
        $netInterestUsd = $netInterest * 1.12; // Example direct conversion
    }

    return [
        'account_id' => $account['account_id'] ."<br>",
        'gross_interest' => round($grossInterest, 2) ."<br>",
        'tax_paid' => round($taxPaid, 2) ."<br>",
        'net_interest' => round($netInterest, 2) ."<br>",
        'net_interest_usd' => round($netInterestUsd, 2) ."<br>",
        'final_balance' => round($finalBalance, 2) ."<br>",
    ];
}

// Process the first account in the array
$processedAccount = processAccount($accounts[0]);

echo "Array\n" . "<br>";
echo "(\n";
foreach ($processedAccount as $key => $value) {
    echo "    [$key] => $value\n";
}
echo ")\n";

?>