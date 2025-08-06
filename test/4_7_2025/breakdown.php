<?php
$accounts = [
    [
        'originalRate' => 0.05,
        'balance' => 30000,
        'start_date' => '2023-01-01',
        'end_date' => '2023-12-31',
        'seasonal-Rate' => [
            ['from' => '2023-06-01', 'to' => '2023-08-31', 'rate_modifier' => 0.01],
            ['from' => '2023-12-01', 'to' => '2023-12-31', 'rate_modifier' => -0.005],
        ]
    ]
];

function getMonthlyBreakdown($account) {
    $results = [];

    $originalRate = $account['originalRate'];
    $balance = $account['balance'];
    $seasonal_rates = $account['seasonal-Rate'];

    $start = new DateTime($account['start_date']);
    $end = new DateTime($account['end_date']);

    $current = clone $start;

    while ($current <= $end) {
        $first_day = new DateTime($current->format('Y-m-01'));
        $last_day = new DateTime($current->format('Y-m-t'));

        $days_in_month = (int)$first_day->diff($last_day)->days + 1;
        $seasonal_modifier_total = 0;

        foreach ($seasonal_rates as $rate) {
            $season_start = new DateTime($rate['from']);
            $season_end = new DateTime($rate['to']);

            // Find overlapping days between this month and seasonal range
            $overlap_start = $season_start > $first_day ? $season_start : $first_day;
            $overlap_end = $season_end < $last_day ? $season_end : $last_day;

            if ($overlap_start <= $overlap_end) {
                $overlap_days = (int)$overlap_start->diff($overlap_end)->days + 1;
                $seasonal_modifier_total += ($overlap_days / $days_in_month) * $rate['rate_modifier'];
            }
        }

        $monthly_rate = $originalRate + $seasonal_modifier_total;
        $monthly_interest = $balance * ($monthly_rate / 12); // since annual rate

        $results[] = [
            'month' => $current->format('F'),
            'days' => $days_in_month,
            'modifier' => round($seasonal_modifier_total, 6),
            'final_rate' => round($monthly_rate, 6),
            'interest' => round($monthly_interest, 2),
        ];

        // Move to next month
        $current->modify('first day of next month');
    }

    return $results;
}

// Run and output
$monthlyDetails = getMonthlyBreakdown($accounts[0]);

foreach ($monthlyDetails as $month) {
    echo "Month: {$month['month']}, Days: {$month['days']}, Modifier: {$month['modifier']}, Final Rate: {$month['final_rate']}, Interest: {$month['interest']}\n" . "<br>";
}
