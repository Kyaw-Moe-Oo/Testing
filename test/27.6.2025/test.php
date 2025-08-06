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

$commission = [];
$flatSales = [];
// $totalSales = 0;

function flattenAndCalculate($data, $upline = [], $level = 0, &$flatSales = [], &$commission = [], $rates = []) {
    foreach ($data as $item) {
        $seller = $item['seller_id'];
        $amount = $item['sale_amount'];

        $flatSales[] = [
            'seller_id' => $seller,
            'sale_amount' => $amount,
            'level' => $level,
            'upline' => $upline
        ];

        // global $totalSales;
        // $totalSales += $amount;

        $commission[$seller] = ($commission[$seller] ?? 0) + ($amount * $rates[1]);

        if ($seller === 'B') {
            $commission[$seller] -= $amount * 0.05;
        } elseif ($seller === 'C') {
            $commission[$seller] -= $amount * 0.05;
            $commission[$seller] -= $amount * 0.03;
        } elseif ($seller === 'D') {
            $commission[$seller] -= $amount * 0.05;
        }

        if (isset($upline[0])) {
            $commission[$upline[0]] = ($commission[$upline[0]] ?? 0) + ($amount * $rates[2]);
        }
        if (isset($upline[1])) {
            $commission[$upline[1]] = ($commission[$upline[1]] ?? 0) + ($amount * $rates[3]);
        }

        if (!empty($item['referrals'])) {
            flattenAndCalculate($item['referrals'], array_merge([$seller], $upline), $level + 1, $flatSales, $commission, $rates);
        }
    }
}

flattenAndCalculate($sales, [], 0, $flatSales, $commission, $commissionRates);

echo " Flat Sales List:<br>";
foreach ($flatSales as $s) {
    echo "Seller: {$s['seller_id']}, Sale: {$s['sale_amount']}, Upline: [" . implode(' > ', $s['upline']) . "], Level: {$s['level']}<br>";
}

echo "<br> Commissions:<br>";
foreach ($commission as $seller => $amount) {
    echo "Seller $seller commission: " . round($amount) . "<br>";
}

// echo "<br> Total Sales: $totalSales<br>";
