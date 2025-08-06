<?php

$sales = [
    [
        'seller_id' => 'A',
        'role' => 'director',
        'sale_amount' => 1000,
        'referrals' => [
            [
                'seller_id' => 'B',
                'role' => 'manager',
                'sale_amount' => 800,
                'referrals' => [
                    [
                        'seller_id' => 'C',
                        'role' => 'agent',
                        'sale_amount' => 600,
                        'referrals' => []
                    ]
                ]
            ],
            [
                'seller_id' => 'D',
                'role' => 'agent',
                'sale_amount' => 500,
                'referrals' => []
            ]
        ]
    ]
];

const COMMISSION_RULES = [
    'self' => [
        'agent' => 0.08,
        'manager' => 0.10,
        'director' => 0.12
    ],
    'upline' => [
        0 => [
            'agent' => 0.02,
            'manager' => 0.04,
            'director' => 0.05
        ],
        1 => [
            'agent' => 0.01,
            'manager' => 0.02,
            'director' => 0.03
        ],
        'default' => 0.01
    ]
];

function calculateCommissions($sales, &$commissions, $upline = [])
{
    foreach ($sales as $sale) {
        $seller = $sale['seller_id'];
        $role = $sale['role'];
        $amount = $sale['sale_amount'];

        $selfRate = COMMISSION_RULES['self'][$role] ?? 0.08;
        $commissions[$seller] = ($commissions[$seller] ?? 0) + ($amount * $selfRate);

        foreach ($upline as $i => $uplineSellerData) {
            $uplineSeller = $uplineSellerData['seller_id'];
            $uplineRole = $uplineSellerData['role'];

            $percent = COMMISSION_RULES['upline'][$i][$uplineRole]
                     ?? COMMISSION_RULES['upline']['default'];

            $commissions[$uplineSeller] = ($commissions[$uplineSeller] ?? 0) + ($amount * $percent);
            $commissions[$seller] -= $amount * $percent;
        }

        if (!empty($sale['referrals'])) {
            $newUpline = array_merge([['seller_id' => $seller, 'role' => $role]], $upline);
            calculateCommissions($sale['referrals'], $commissions, $newUpline);
        }
    }
}

$commissions = [];
calculateCommissions($sales, $commissions);

foreach ($commissions as $seller => $amount) {
    echo "Seller $seller commission: " . round($amount, 2) . "<br>";
}
