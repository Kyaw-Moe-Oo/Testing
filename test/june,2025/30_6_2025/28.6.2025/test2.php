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
    'director' => 1000, // $100 per $1000 team sales
    'manager' => 500    // $100 per $500 team sales
];

function calculateCommissions($sales, &$results = [], $uplines = []) {
    foreach ($sales as $seller) {
        $id = $seller['seller_id'];
        $role = $seller['role'];

        // Initialize results
        if (!isset($results[$id])) {
            $results[$id] = [
                'role' => $role,
                'self_commission' => 0,
                'upline_commission' => 0,
                'team_sales' => 0,
                'bonus' => 0,
            ];
        }

        // Self sales and commissions
        foreach ($seller['products'] as $product) {
            $category = $product['category'];
            $amount = $product['amount'];
            $results[$id]['team_sales'] += $amount;

            // Self commission
            $self_rate = COMMISSION_RULES[$category]['self'][$role] ?? 0;
            $results[$id]['self_commission'] += $amount * $self_rate;

            // Upline commission distribution
            foreach ($uplines as $level => $upline) {
                $upline_id = $upline['seller_id'];
                $upline_role = $upline['role'];
                if (!isset($results[$upline_id])) {
                    $results[$upline_id] = [
                        'role' => $upline_role,
                        'self_commission' => 0,
                        'upline_commission' => 0,
                        'team_sales' => 0,
                        'bonus' => 0,
                    ];
                }

                $upline_rate = COMMISSION_RULES[$category]['upline'][$level][$upline_role]
                    ?? (COMMISSION_RULES[$category]['upline']['default'] ?? 0);
                $results[$upline_id]['upline_commission'] += $amount * $upline_rate;
                $results[$upline_id]['team_sales'] += $amount;
            }
        }

        // Process referrals recursively
        if (!empty($seller['referrals'])) {
            $newUplines = array_merge([$seller], $uplines);
            calculateCommissions($seller['referrals'], $results, $newUplines);
        }
    }

    // Bonus calculation after full team sale is known
    foreach ($results as $seller_id => &$data) {
        $threshold = BONUS_RULES[$data['role']] ?? 0;
        if ($threshold > 0) {
            $data['bonus'] = floor($data['team_sales'] / $threshold) * 100;
        }
    }

    return $results;
}



$results = [];
calculateCommissions($sales, $results);

print_r($results) . "<br>";

?>