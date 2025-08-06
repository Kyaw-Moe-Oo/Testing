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
function calculateCommissions($sales, &$commissions, $upline = [])
{
    foreach ($sales as $sale) {

        $seller = $sale['seller_id'];//A,B,C,D
        $amount = $sale['sale_amount'];//1000,800,600
        $commissions[$seller] = 0.0;//
        $commissions[$seller] += $amount * 0.10;//$commession['A'=>100],$commession['B'=>80],$commession['C'=>60]

        foreach ($upline as $i => $uplineSeller) {//[0=>'A'],[0=>'B',1=>'A']
            if ($i == 0) {
                $percent = 0.05; // B
            } elseif ($i == 1) {
                $percent = 0.03; // C
            } else {
                $percent = 0.01; // Default
            }
            $commissions[$uplineSeller] += $amount * $percent;//$commession['A'=>100+800*0.05]
            $commissions[$seller] -= $amount * $percent;
        }
        if (!empty($sale['referrals'])) {
            $newUpline = array_merge([$seller], $upline);//[A],[B,A],[C,B,A]
            // var_dump($newUpline);
            // die();
            calculateCommissions($sale['referrals'], $commissions, $newUpline);//[nestedArr],[empty],[A],depth=1
        }
    }
}

$commissions = [];
calculateCommissions($sales, $commissions);

var_dump($commissions);
?>