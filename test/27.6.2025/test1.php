<?php

$sales = [
    [
        'seller_id' => 'A',
        'sale_amount' => 1000,
        'referrals' => [
            [
                'seller_id' => 'B',
                'sale_amount' => 800,
                'referrals' => [
                    [
                        'seller_id' => 'C',
                        'sale_amount' => 600,
                        'referrals' => []
                    ]
                ]
            ],
            [
                'seller_id' => 'D',
                'sale_amount' => 500,
                'referrals' => []
            ]
        ]
    ]
];

$commissionRates = [
    1 => 0.10,
    2 => 0.05,
    3 => 0.03
];

$selfBonusRate = 0.02;

$commission = [];

function distributeCommission($seller, $uplineChain = []) {
    global $commission, $commissionRates, $selfBonusRate;

    $sellerId = $seller['seller_id'];
    $amount = $seller['sale_amount'];

    $commission[$sellerId] = ($commission[$sellerId] ?? 0) + ($amount * $selfBonusRate);

    foreach ($uplineChain as $depth => $upline) {
        $level = $depth + 1;
        $rate = $commissionRates[$level] ?? 0.03;
        $commission[$upline] = ($commission[$upline] ?? 0) + ($amount * $rate);
    }

    foreach ($seller['referrals'] as $ref) {
        distributeCommission($ref, array_merge([$sellerId], $uplineChain));
    }
}

foreach ($sales as $top) {
    distributeCommission($top);
}

echo " Final Commission Report:" . "<br>";
foreach ($commission as $seller => $amount) {
    echo "Seller $seller earns: " . round($amount) . "<br>";
}
