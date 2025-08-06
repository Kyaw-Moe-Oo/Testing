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
    'director' => 1000, // gets $100 bonus for every $1000 in team sales
    'manager' => 500, // gets $100 bonus for every $500 in team sales 
];

function calculateAll($node, &$commissions, $uplines = []) {
    $id = $node['seller_id'];
    $role = $node['role'];
    $totalSales = 0;

    // Self commission
    foreach ($node['products'] as $product) {
        $category = $product['category'];
        $amount = $product['amount'];
        $totalSales += $amount;

        $selfRate = COMMISSION_RULES[$category]['self'][$role] ?? 0;
        $commissions[$id] = ($commissions[$id] ?? 0) + $amount * $selfRate;

        // Upline commissions
        foreach ($uplines as $level => $upl) {
            $uplId = $upl['seller_id'];
            $uplRole = $upl['role'];
            $uplRate = COMMISSION_RULES[$category]['upline'][$level][$uplRole] ??
                       COMMISSION_RULES[$category]['upline']['default'] ?? 0;

            $commissions[$uplId] = ($commissions[$uplId] ?? 0) + $amount * $uplRate;
        }
    }

    // Process referrals and accumulate team sales
    foreach ($node['referrals'] as $ref) {
        $totalSales += calculateAll($ref, $commissions, array_merge([['seller_id' => $id, 'role' => $role]], $uplines));
    }

    // Bonus
    if (isset(BONUS_RULES[$role])) {
        $threshold = BONUS_RULES[$role];
        $bonus = floor($totalSales / $threshold) * ($threshold / 10); // e.g. 1000 → 100
        $commissions[$id] += $bonus;
    }

    return $totalSales;
}

// Run for top-level sellers
$commissions = [];
foreach ($sales as $node) {
    calculateAll($node, $commissions);
}

// Output result
foreach ($commissions as $seller => $amount) {
    echo "Seller $seller earns $amount" . "<br>";
}
