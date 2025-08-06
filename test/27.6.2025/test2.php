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

function flattenSales($data, $upline = [], $level = 0, &$flatSales = []) {
    foreach ($data as $item) {
        $sellerId = $item['seller_id'];
        $amount = $item['sale_amount'];

        $flatSales[] = [
            'seller_id' => $sellerId,
            'sale_amount' => $amount,
            'level' => $level,
            'upline' => $upline
        ];

        if (!empty($item['referrals'])) {
            flattenSales($item['referrals'], array_merge([$sellerId], $upline), $level + 1, $flatSales);
        }
    }
}

function calculateCommission($flatSales, $commissionRates) {
    $commission = [];

    foreach ($flatSales as $entry) {
        $seller = $entry['seller_id'];
        $amount = $entry['sale_amount'];
        $uplines = $entry['upline'];

        $commission[$seller] = ($commission[$seller] ?? 0) + ($amount * $commissionRates[1]);

        if ($seller === 'B') {
            $commission[$seller] -= $amount * 0.05;
        } elseif ($seller === 'C') {
            $commission[$seller] -= $amount * 0.05;
            $commission[$seller] -= $amount * 0.03;
        } elseif ($seller === 'D') {
            $commission[$seller] -= $amount * 0.05;
        }

        if (isset($uplines[0])) {
            $commission[$uplines[0]] = ($commission[$uplines[0]] ?? 0) + ($amount * 0.05);
        }
        if (isset($uplines[1])) {
            $commission[$uplines[1]] = ($commission[$uplines[1]] ?? 0) + ($amount * 0.03); 
        }
    }

    return $commission;
}

$flatSales = [];
flattenSales($sales, [], 0, $flatSales);
$commission = calculateCommission($flatSales, $commissionRates);
$totalSales = array_sum(array_column($flatSales, 'sale_amount'));

echo "Flat Sales List:<br>";
foreach ($flatSales as $s) {
    echo "Seller: {$s['seller_id']}, Sale: {$s['sale_amount']}, Upline: [" . implode(' > ', $s['upline']) . "], Level: {$s['level']}<br>";
}

echo "<br>Commissions:<br>";
foreach ($commission as $seller => $amount) {
    echo "Seller $seller commission: " . round($amount) . "<br>";
}

echo "<br>Total Sales: $totalSales<br>";
