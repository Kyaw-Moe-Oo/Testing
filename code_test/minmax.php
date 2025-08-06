<?php
function findMinMax($arr = []) {
    if (count($arr) === 0) {
        return ['min' => null, 'max' => null];
}
    $minValue = $arr[0];
    $maxValue = $arr[0];
for ($i = 1; $i < count($arr); $i++) {
    if ($arr[$i] < $minValue) {
        $minValue = $arr[$i];
    }

    if ($arr[$i] > $maxValue) {
            $maxValue = $arr[$i];
    }
}

    return ['min' => $minValue, 'max' => $maxValue];
}
$array = [7, 2, 5, 8, 10, 1, 6];
$result = findMinMax($array);

echo "Minimum Value: " . $result['min'] . "<br>";
echo "Maximum Value: " . $result['max'];
?>
