<?php
$num = [1,2,3,4,6,7,8,9,10];
$eventNumber = [];
$oddNumber = [];
$count = count($num);
for ($i = 0; $i < $count; $i++) {
    if ($num[$i] % 2 == 0) {
        $eventNumber[] = $num[$i];
    } else {
        $oddNumber[] = $num[$i];
    }
}
echo "Event Number : " . implode(", ", $eventNumber) . "<br>";
echo "Odd Number : " . implode(", ", $oddNumber) . "<br>";

?>