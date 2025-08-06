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

$account = $accounts[0];

$balance = $account['balance'];
$start = new DateTime($account['start_date']);
$end = new DateTime($account['end_date']);
$interval = $start->diff($end)->days;

$daily_bal = $balance;//30000
$gross_interest = 0;


$transaction_map = [];
foreach ($account['transactions'] as $txn) {
    $transaction_map[$txn['date']][] = $txn;
}


for ($i = 0; $i <= $interval; $i++) {
    $date = clone $start;
    $date->modify("+$i days");
    $date_str = $date->format('Y-m-d');

    //သက်ဆိုင်တဲ့ transaction တွေရှိလားစစ်
    if (isset($transaction_map[$date_str])) {
        foreach ($transaction_map[$date_str] as $txn) {
            if ($txn['type'] === 'deposit') {
                $daily_bal += $txn['amount'];
            } elseif ($txn['type'] === 'withdrawal') {
                $daily_bal -= $txn['amount'];
            }
        }
    }

    // Tier-based rate 
    $rate = 0;
    foreach ($account['tiers'] as $tier) {
        if ($tier['up_to'] === null || $daily_bal <= $tier['up_to']) {
            $rate = $tier['rate'];//0.07
            break;
        }
    }
    
    //  season rate modifier
    foreach ($account['seasonal_rates'] as $season) {
        if ($date_str >= $season['from'] && $date_str <= $season['to']) {
            $rate += $season['rate_modifier'];
        }
    }

    //  Daily compound interest
    $daily_interest = $daily_bal * ($rate / 365);
    $daily_bal += $daily_interest;
    $gross_interest += $daily_interest;
}

//  Cap interest
$interest_cap = $account['interest_cap'];

if ($gross_interest > $interest_cap) {
    $gross_interest = $interest_cap;
}

//  Tax
$tax_paid = 0;
$remaining = $gross_interest;
foreach ($account['tax_brackets'] as $bracket) {
    $limit = $bracket['up_to'];
    $rate = $bracket['rate'];
    // var_dump($limit);die();
    if ($limit === null) {
        $tax_paid += $remaining * $rate;
        break;
    } elseif ($remaining > $limit) {
        $tax_paid += $limit * $rate;
        $remaining -= $limit;
    } else {
        $tax_paid += $remaining * $rate;
        break;
    }
}

//  Net Interest
$net_interest = $gross_interest - $tax_paid;

//  USD ပြောင်း
$hedge_rate = $account['fx_hedging']['hedge_rate'];
$net_interest_usd = $net_interest * $hedge_rate;

//  Final Balance
$final_balance = $balance;

//  Transaction နဲ့ အတိုးများထည့်ပြီး balance ကို တိတိအောင်ထည့်
foreach ($account['transactions'] as $txn) {
    if ($txn['type'] === 'deposit') {
        $final_balance += $txn['amount'];
    } elseif ($txn['type'] === 'withdrawal') {
        $final_balance -= $txn['amount'];
    }
}
$final_balance += $net_interest;

//  Output
$result = [
    'account_id' => $account['account_id'],
    'gross_interest' => round($gross_interest, 2),
    'tax_paid' => round($tax_paid, 2),
    'net_interest' => round($net_interest, 2),
    'net_interest_usd' => round($net_interest_usd, 2),
    'final_balance' => round($final_balance, 2),
];

print_r($result);
?>