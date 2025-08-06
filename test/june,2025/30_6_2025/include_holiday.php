<?php

$accounts = [
    [
        'account_id' => 'A1001',
        'balance' => 12000,
        'interest_type' => 'compound',
        'rate' => 0.05,
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

// Define official holidays (you can expand this list)
$holidays = [
   '2023-01-01',//new year's day
   '2023-01-04',//independence
   '2023-02-12',//union
   '2023-03-02',//peasant's day
   '2023-03-05',//full moon day of Tabaung
  '2023-03-27',//	Armed Forces Day
  '2023-04-09','2023-04-10','2023-04-11','2023-04-12',
  '2023-04-13','2023-04-14','2023-04-15','2023-04-16','2023-04-17',
  //Thingyan (the Water Festival) including Burmese New Year
  '2023-05-01',//	Labour Day
  '2023-05-03',//	Full Moon Day of Kasong (Vesak
  '2023-06-29',//Eid al‑Adha (Islamic holiday)
  '2023-07-19',//Martyrs’ Day
  '2023-08-01',//	Full Moon Day of Waso (start of Buddhist Lent)
  '2023-10-28','2023-10-29','2023-10-30',//Thadingyut (Lighting Festival) – Pre-FM, FM & Post-FM Days
  '2023-11-26','2023-11-27',	//Tazaungmone (Festival of Lights – Full Moon Day & Holiday)
  '2023-12-07',//National Day
  '2023-12-25',//	Christmas Day
  '2023-12-31'//	New Year’s Eve Holiday
    // add more if needed
];

foreach ($accounts as $account) {
    $start = new DateTime($account['start_date']);
    $end = new DateTime($account['end_date']);
    $balance = $account['balance'];
    $annualRate = $account['rate'];

    if ($account['interest_type'] === 'compound') {
        $compounding = $account['compounding'];
        $interval = $start->diff($end);
        $months = ($interval->y * 12) + $interval->m + 1;
        $periodRate = $annualRate / 12;
        $futureValue = $balance * pow((1 + $periodRate), $months);
        $interest = $futureValue - $balance;
        echo "Account {$account['account_id']}<br>";
        echo "Compound Interest (Monthly): " . number_format($interest, 2) . "<br><br>";
    } else {
        $weekdays = 0;
        $current = clone $start; // Clone to avoid modifying original
        while ($current <= $end) {
            $dateStr = $current->format('Y-m-d');
            $isWeekday = (int)$current->format('N') <= 5;
            $isHoliday = in_array($dateStr, $holidays);

            if ($isWeekday && !$isHoliday) {
                $weekdays++;
            }

            $current->modify('+1 day');
        }

        $yearProportion = $weekdays / 365;
        $effectiveRate = $annualRate * $yearProportion;
        $interest = $balance * $effectiveRate;

        echo "Account {$account['account_id']}<br>";
        echo "Simple Interest (Excl. weekends & holidays): " . number_format($interest, 2) . "<br><br>";
    }
}
