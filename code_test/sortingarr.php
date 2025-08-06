<?php
    $myArray = [64, 34, 25, 12, 22, 11, 90,95];
    function FindSortingArray($arr){
        if (count($arr) <= 1) {
        return $arr;
    }
        $num = count($arr);
        for ($i = 0; $i < $num - 1; $i++) {
        $swapped = false;
        for ($j = 0; $j < $num - $i - 1; $j++) {
            if ($arr[$j] > $arr[$j + 1]) {
                $temp = $arr[$j];
                $arr[$j] = $arr[$j + 1];
                $arr[$j + 1] = $temp;
                $swapped = true;
            }
        }
        if ($swapped == false) {
            break;
        }
    }

    return $arr;

}
echo 'Original Array : ';
print_r($myArray);
echo '<br>';

$sortedArray = FindSortingArray($myArray);
echo 'Sorded Array (Bubble Sort) : ';
print_r($sortedArray);
?>
