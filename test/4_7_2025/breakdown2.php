<?php

$account = [
    'balance' => 30000,
    'start_date' => '2023-01-01',
    'end_date' => '2023-12-31',
    'originalRate' => 0.05, // 5%
    'seasonalRates' => [
        ['from' => '2023-06-01', 'to' => '2023-08-31', 'rate_modifier' => 0.02], // summer boost
        ['from' => '2023-12-01', 'to' => '2023-12-31', 'rate_modifier' => -0.01], // winter drop (fixed)
    ],
];

function validateAccount(array $account): bool {
    $requiredFields = ['balance', 'start_date', 'end_date', 'originalRate', 'seasonalRates'];
    validateRequiredFields($account, $requiredFields);
    validateNumericField($account['balance'], 'balance');
    validateNumericField($account['originalRate'], 'originalRate');
    validateDateRange($account['start_date'], $account['end_date']);
    validateSeasonalRates($account['seasonalRates']);
    return true;
}

function validateRequiredFields(array $data, array $fields): void {
    foreach ($fields as $field) {
        if (!isset($data[$field])) {
            throw new Exception("Missing required field: $field");
        }
    }
}

function validateNumericField($value, string $fieldName): void {
    if (!is_numeric($value) || $value < 0) {
        throw new Exception(ucfirst($fieldName) . " must be a non-negative number.");
    }
}

function validateDateRange(string $startDate, string $endDate): void {
    $start = DateTime::createFromFormat('Y-m-d', $startDate);
    $end = DateTime::createFromFormat('Y-m-d', $endDate);

    if (!$start || !$end) {
        throw new Exception("Invalid date format for start or end date. Use YYYY-MM-DD.");
    }

    if ($start > $end) {
        throw new Exception("Start date cannot be after end date.");
    }
}

function validateSeasonalRates($seasonalRates): void {
    if (!is_array($seasonalRates)) {
        throw new Exception("seasonalRates must be an array.");
    }

    foreach ($seasonalRates as $index => $rate) {
        if (!isset($rate['from'], $rate['to'], $rate['rate_modifier'])) {
            throw new Exception("Each seasonal rate must include 'from', 'to', and 'rate_modifier'. Error at index $index.");
        }

        $from = DateTime::createFromFormat('Y-m-d', $rate['from']);
        $to = DateTime::createFromFormat('Y-m-d', $rate['to']);
        if (!$from || !$to) {
            throw new Exception("Invalid date format in seasonal rate at index $index.");
        }

        if ($from > $to) {
            throw new Exception("'from' date cannot be after 'to' date in seasonal rates at index $index.");
        }

        if (!is_numeric($rate['rate_modifier'])) {
            throw new Exception("rate_modifier must be numeric at index $index.");
        }
    }
}


function getSeasonalModifier($dateStr, $seasonalRates) {
    foreach ($seasonalRates as $rate) {
        $from = new DateTime($rate['from']);
        $to = new DateTime($rate['to']);
        $date = new DateTime($dateStr);

        if ($date >= $from && $date <= $to) {
            return $rate['rate_modifier'];
        }
    }
    return 0;
}

// function calculateMonthlyInterest($account) {
//     validateAccount($account);

//     $start = new DateTime($account['start_date']);
//     $end = new DateTime($account['end_date']);
//     $originalRate = $account['originalRate'];
//     $seasonalRates = $account['seasonalRates'];
//     $balance = $account['balance'];

//     $monthlyInterest = [];
//     $monthlyTotalBalance = [];
//     $totalInterest = 0.0;

//     $date = clone $start;

//     while ($date <= $end) {
//         $dateStr = $date->format('Y-m-d');
//         $monthKey = $date->format('Y-m');

//         $modifier = getSeasonalModifier($dateStr, $seasonalRates);
//         $dailyRate = ($originalRate + $modifier) / 365;

//         $interest = $balance * $dailyRate;
//         $balance += $interest;
//         $totalInterest += $interest;

//         if (!isset($monthlyInterest[$monthKey])) {
//             $monthlyInterest[$monthKey] = 0.0;
//         }

//         $monthlyInterest[$monthKey] += $interest;

//         // Save end-of-month balance
//         $nextDay = (clone $date)->modify('+1 day');
//         if ($nextDay->format('m') !== $date->format('m')  $date == $end) {
//             $monthlyTotalBalance[$monthKey] = round($balance, 2);
//         }

//         $date->modify('+1 day');
//     }

//     // Round interest values
//     foreach ($monthlyInterest as $month => $value) {
//         $monthlyInterest[$month] = round($value, 2);
//     }

//     return [
//         'monthly_interest' => $monthlyInterest,
//         'monthly_total_balance' => $monthlyTotalBalance,
//         'total_interest' => round($totalInterest, 2),
//         'final_balance' => round($balance, 2),
//     ];
// }

function calculateMonthlyInterest($account) {
    validateAccount($account);

    $start = new DateTime($account['start_date']);
    $end = new DateTime($account['end_date']);
    $originalRate = $account['originalRate'];
    $seasonalRates = $account['seasonalRates'];
    $balance = $account['balance'];

    $monthlySummary = [];
    $totalInterest = 0.0;

    $date = clone $start;

    while ($date <= $end) {
        $dateStr = $date->format('Y-m-d');
        $monthKey = $date->format('Y-m');

        $modifier = getSeasonalModifier($dateStr, $seasonalRates);
        $dailyRate = ($originalRate + $modifier) / 365;

        $interest = $balance * $dailyRate;
        $balance += $interest;
        $totalInterest += $interest;

        // Initialize monthly record if not set
        if (!isset($monthlySummary[$monthKey])) {
            $monthlySummary[$monthKey] = [
                'interest' => 0.0,
                'end_balance' => 0.0,
            ];
        }

        // Add daily interest
        $monthlySummary[$monthKey]['interest'] += $interest;

        // If it's the end of the month or the final date, update end balance
        $nextDay = (clone $date)->modify('+1 day');
        if ($nextDay->format('m') !== $date->format('m') || $date == $end) {
            $monthlySummary[$monthKey]['end_balance'] = round($balance, 2);
            // Round interest once end-of-month is confirmed
            $monthlySummary[$monthKey]['interest'] = round($monthlySummary[$monthKey]['interest'], 2);
        }

        $date->modify('+1 day');
    }
    return [
        'monthly_summary' => $monthlySummary,
        'total_interest' => round($totalInterest, 2),
        'final_balance' => round($balance, 2),
    ];
    
}
$result = calculateMonthlyInterest($account);

// JSON-encoded output
header('Content-Type: application/json');
echo json_encode($result, JSON_PRETTY_PRINT);


try {
    $json = file_get_contents('result.json'); // or from API
    $data = json_decode($json, true); // true = decode as associative array
    print_r($data['monthly_summary']);
} catch (Exception $e) {
    echo "<strong>Error:</strong> " . $e->getMessage();
}
?>