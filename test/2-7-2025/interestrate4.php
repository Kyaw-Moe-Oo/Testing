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
        ],
        'seasonal_rates' => [
            ['from' => '2023-06-01', 'to' => '2023-08-31', 'rate_modifier' => 0.01],
            ['from' => '2023-12-01', 'to' => '2023-12-31', 'rate_modifier' => -0.005],
        ],
        'penalties' => [
            'early_withdrawal' => 0.02
        ],
        'bonuses' => [
            'loyalty_bonus' => [
                'after_months' => 12,
                'rate_boost' => 0.01
            ]
        ],
        'account_type' => 'savings',
        'risk_profile' => 'low',
        'compliance_flags' => [
            'high_volume_txns' => false,
            'large_foreign_deposits' => false,
        ],
        'fx_hedging' => [
            'enabled' => true,
            'hedge_rate' => 1.12
        ],
        'interest_cap' => 1500,
        'interest_floor' => 0,
        'account_holder' => [
            'name' => 'Max Mustermann',
            'dob' => '1985-06-01',
            'nationality' => 'DE',
            'residency' => 'DE',
            'kyc_status' => 'verified'
        ],
        'tax_brackets' => [
            ['up_to' => 1000, 'rate' => 0.10],
            ['up_to' => 5000, 'rate' => 0.20],
            ['up_to' => null, 'rate' => 0.30]
        ],
        'transactions' => [
            ['date' => '2023-01-10', 'type' => 'deposit', 'amount' => 10000],
            ['date' => '2023-04-15', 'type' => 'deposit', 'amount' => 10000],
            ['date' => '2023-09-20', 'type' => 'withdrawal', 'amount' => 5000],
        ],
        'bank' => [
            'id' => 'BANK001',
            'name' => 'Global Bank',
            'country' => 'DE',
            'regulatory_tier' => 'Tier 1'
        ]
    ],
];



function getTieredRate($balance, $tiers)
{
    $interest = 0;
    $remaining = $balance;
    $lastCap = 0;

    foreach ($tiers as $tier) {
        $cap = $tier['up_to'] ?? $balance;
        $amountInTier = min($remaining, $cap - $lastCap);
        if ($amountInTier > 0) {
            $interest += $amountInTier * $tier['rate'];
            $remaining -= $amountInTier;
        }
        $lastCap = $cap;
        if ($remaining <= 0) break;
    }

    return $interest / $balance;
}

function getAverageSeasonalModifier(DateTime $start, DateTime $end, array $seasonalRates): float
{
    $totalDays = (int)$start->diff($end)->days + 1;
    $weightedSum = 0;

    foreach ($seasonalRates as $season) {
        $seasonStart = new DateTime($season['from']);//2023-06-01
        $seasonEnd = new DateTime($season['to']);//2023-08-31
        //2023-01-01 , 2023-12-31
        // Calculate overlap
        $overlapStart = $seasonStart > $start ? $seasonStart :  $start;//2023-06-01
        $overlapEnd = $seasonEnd < $end ? $seasonEnd :  $end;//2023-08-31

        if ($overlapStart <= $overlapEnd) {
            $daysInSeason = (int)$overlapStart->diff($overlapEnd)->days + 1;//92
            
            $weightedSum += $daysInSeason * $season['rate_modifier'];
        }
    }

    return $totalDays > 0 ? $weightedSum / $totalDays : 0.0;
}

function applyLoyaltyBonus($rate, $startDate, $endDate, $bonus)
{
    $interval = $startDate->diff($endDate);
    if ($interval->m + ($interval->y * 12) >= $bonus['after_months']) {
        return $rate + $bonus['rate_boost'];
    }
    return $rate;
}

function applyInterestCapFloor($interest, $cap, $floor)
{
    return max($floor, min($interest, $cap));
}
function calculateTax($interest, $brackets)
{
    $tax = 0;
    $remaining = $interest;
    $lastCap = 0;
    foreach ($brackets as $bracket) {
        $cap = $bracket['up_to'] ?? $interest;
        $taxable = min($remaining, $cap - $lastCap);
        if ($taxable > 0) {
            $tax += $taxable * $bracket['rate'];
            $remaining -= $taxable;
        }
        $lastCap = $cap;
        if ($remaining <= 0) break;
    }

    return $tax;
}

// --- Main Calculation ---

function calculateInterest($accounts)
{
    foreach ($accounts as $account) {
        $id = $account['account_id'];
        $balance = $account['balance'];
        $start = new DateTime($account['start_date']);
        $end = new DateTime($account['end_date']);
        $originalStart = clone $start;
        $compounding = $account['compounding'];
        $tiers = $account['tiers'];
        $seasonalRates = $account['seasonal_rates'];
        $bonus = $account['bonuses']['loyalty_bonus'];
        $cap = $account['interest_cap'];
        $floor = $account['interest_floor'];
        $hedgeRate = $account['fx_hedging']['hedge_rate'];
        $taxBrackets = $account['tax_brackets'];
        $transactions = $account['transactions'];
         $penaltyRate = $account['penalties']['early_withdrawal'] ?? 0;
         $totalPenalty = 0;

        // Apply transactions
        foreach ($transactions as $txn) {
            $txnDate = new DateTime($txn['date']);
            if ($txnDate < $end) {
                if ($txn['type'] === 'deposit') {
                    $balance += $txn['amount'];
                } elseif ($txn['type'] === 'withdrawal') {
                    $balance -= $txn['amount'];
                    $totalPenalty += $txn['amount'] * $penaltyRate;
                }
            }
        }

        // Average rate
        $avgTierRate = getTieredRate($balance, $tiers);//
        $avgSeasonalModifier = getAverageSeasonalModifier($start, $end, $seasonalRates);
        $avgRate = $avgTierRate + $avgSeasonalModifier;

        // Loyalty bonus
        if ($bonus) {
            $avgRate = applyLoyaltyBonus($avgRate, $originalStart, $end, $bonus);
        }

        // Compound interest calculation
        $n = match ($compounding) {
            'daily' => 365,
            'monthly' => 12,
            'quarterly' => 4,
            'annually' => 1,
            default => 365
        };

        $days = (int)$start->diff($end)->days + 1;
        $t = $days / 365;

        $final = $balance * pow(1 + $avgRate / $n, $n * $t);
        $grossInterest = $final - $balance;

        // Cap/Floor
        $grossInterest = applyInterestCapFloor($grossInterest, $cap, $floor);
        $taxPaid = calculateTax($grossInterest, $taxBrackets);
        $netInterest = $grossInterest - $taxPaid;
        $netInterestUSD = $netInterest * $hedgeRate;
        $finalBalance = $balance + $netInterest - $totalPenalty;

        // Output
        $result = [
            'account_id' => $id,
            'gross_interest' => round($grossInterest, 2),
            'tax_paid' => round($taxPaid, 2),
            'net_interest' => round($netInterest, 2),
            'net_interest_usd' => round($netInterestUSD, 2),
            'penalty_applied' => round($totalPenalty,2),
            'final_balance' => round($finalBalance, 2),
        ];

        echo "<pre>";
        print_r($result);
        echo "</pre>";
    }
}

//  Run the calculation
calculateInterest($accounts);