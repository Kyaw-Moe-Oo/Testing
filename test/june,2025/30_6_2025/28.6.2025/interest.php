<?php 
$accounts = [
    [
        'account_id' => 'A1001',
        'balance' => 12000,
        'interest_type' => 'compound', // or 'simple'
        'rate' => 0.05, // annual 5%
        'compounding' => 'monthly',
        'start_date' => '2023-01-01',
        'end_date' => '2023-12-31',
    ],
    [
        'account_id' => 'A1002',
        'balance' => 5000,
        'interest_type' => 'simple',
        'rate' => 0.03,
        'compounding' => 'daily',
        'start_date' => '2023-06-01',
        'end_date' => '2023-09-01',
    ]
];
function calculateInterest($accounts) {
    $results = [];

    foreach ($accounts as $acc) {
        $start = new DateTime($acc['start_date']);
        $end = new DateTime($acc['end_date']);
        $balance = $acc['balance'];
        $rate = $acc['rate'];
        $type = $acc['interest_type'];
        $compound = $acc['compounding'];

        $interest = 0;
        $days = 0;

        $interval = match ($compound) {
            'daily' => 'P1D',
            'weekly' => 'P1W',
            'monthly' => 'P1M',
            'yearly' => 'P1Y',
            default => 'P1D'
        };

        $current = clone $start;

        if ($type === 'simple') {
            // Count valid days (skip weekends)
            while ($current <= $end) {
                $dayOfWeek = $current->format('N');
                if ($dayOfWeek < 6) { // 1=Mon, 7=Sun
                    $days++;
                }
                $current->add(new DateInterval('P1D'));
            }

            $interest = $balance * $rate * ($days / 365);
        } else {
            // Compound interest
            $compoundDates = [];
            while ($current <= $end) {
                $dayOfWeek = $current->format('N');
                if ($dayOfWeek < 6) {
                    $compoundDates[] = clone $current;
                }
                $current->add(new DateInterval($interval));
            }

            foreach ($compoundDates as $cd) {
                $balance += $balance * ($rate / getCompoundingPeriodsPerYear($compound));
            }

            $interest = $balance - $acc['balance'];
        }

        $results[] = [
            'account_id' => $acc['account_id'],
            'interest' => round($interest, 2),
            'final_balance' => round($acc['balance'] + $interest, 2)
        ];
    }

    return $results;
}

function getCompoundingPeriodsPerYear($frequency) {
    return match ($frequency) {
        'daily' => 365,
        'weekly' => 52,
        'monthly' => 12,
        'yearly' => 1,
        default => 1
    };
}

// Example output
$results = calculateInterest($accounts);
print_r($results) . "<br>";
?>