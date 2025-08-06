<?php

$sales = [
    [
        'seller_id' => 'A',
        'role' => 'director',
        'products' => [
            ['category' => 'software', 'amount' => 1000],
            ['category' => 'hardware', 'amount' => 500],
        ],
        'referrals' => [
            [
                'seller_id' => 'B',
                'role' => 'manager',
                'products' => [
                    ['category' => 'software', 'amount' => 800]
                ],
                'referrals' => [
                    [
                        'seller_id' => 'C',
                        'role' => 'agent',
                        'products' => [
                            ['category' => 'hardware', 'amount' => 600]
                        ],
                        'referrals' => []
                    ]
                ]
            ]
        ]
    ]
];

const COMMISSION_RULES = [
    'software' => [
        'self' => ['agent' => 0.05, 'manager' => 0.07, 'director' => 0.10],
        'upline' => [
            0 => ['agent' => 0.01, 'manager' => 0.02, 'director' => 0.03],
            1 => ['agent' => 0.005, 'manager' => 0.01, 'director' => 0.02],
            'default' => 0.005
        ]
    ],
    'hardware' => [
        'self' => ['agent' => 0.04, 'manager' => 0.06, 'director' => 0.08],
        'upline' => [
            0 => ['agent' => 0.01, 'manager' => 0.015, 'director' => 0.025],
            1 => ['agent' => 0.005, 'manager' => 0.007, 'director' => 0.01],
            'default' => 0.003
        ]
    ]
];

const BONUS_RULES = [
    'director' => 1000, // gets $10% bonus for every $1000 in team sales not himself 
    'manager' => 500, // gets $10% bonus for every $500 in team sales not himself
];

function calculateCommissions($sales, &$commissions, &$teamSales, $upline = [])
{
    foreach ($sales as $sale) {
        $seller = $sale['seller_id'];
        $role = $sale['role'];

        foreach ($sale['products'] as $product) {
            $category = $product['category'];
            $amount = $product['amount'];

            $selfRate = COMMISSION_RULES[$category]['self'][$role] ?? 0;
            $commission = $amount * $selfRate;
            $commissions[$seller] = ($commissions[$seller] ?? 0) + $commission;

            // Upline commissions
            foreach ($upline as $i => $uplineSeller) {
                $uplineId = $uplineSeller['seller_id'];
                $uplineRole = $uplineSeller['role'];

                $uplineRate = COMMISSION_RULES[$category]['upline'][$i][$uplineRole]
                            ?? COMMISSION_RULES[$category]['upline']['default'];

                $uplineCommission = $amount * $uplineRate;
                $commissions[$uplineId] = ($commissions[$uplineId] ?? 0) + $uplineCommission;

                // Deduct from current seller
                $commissions[$seller] -= $uplineCommission;
            }

            // Track for bonus calculations
            $teamSales[$seller] = ($teamSales[$seller] ?? 0) + $amount;
            foreach ($upline as $uplineSeller) {
                $uplineId = $uplineSeller['seller_id'];
                $teamSales[$uplineId] = ($teamSales[$uplineId] ?? 0) + $amount;
            }
        }

        // Process referrals
        if (!empty($sale['referrals'])) {
            $newUpline = array_merge([['seller_id' => $seller, 'role' => $role]], $upline);
            calculateCommissions($sale['referrals'], $commissions, $teamSales, $newUpline);
        }
    }
}

$commissions = [];
$teamSales = [];
calculateCommissions($sales, $commissions, $teamSales);

// Add bonuses
foreach ($teamSales as $seller => $totalSales) {
    if (isset(BONUS_RULES[$sales[0]['role']])) {
        $role = '';
        foreach ($sales as $s) {
            if ($s['seller_id'] === $seller) {
                $role = $s['role'];
                break;
            }
        }
    }
    if (isset(BONUS_RULES[$role])) {
        $unit = BONUS_RULES[$role];
        $bonus = floor($totalSales / $unit) * 100;
        $commissions[$seller] += $bonus;
    }
}

// Output
foreach ($commissions as $seller => $amount) {
    echo "Seller $seller commission: $" . round($amount, 2) . "<br>";
}

?>