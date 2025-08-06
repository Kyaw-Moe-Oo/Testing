<?php
$originalArray = [1,8,1,1,2,3,4];
function FindRotateArray($arr){
    if (count($arr) <=1 ){
        return $arr;
    }
    $LastElement = $arr [ count($arr) - 1];
    for ( $i = count($arr) - 1; $i > 0; $i--) {
        $arr[$i] = $arr[$i-1];
    }
    $arr[0] = $LastElement;
    return $arr;
}
echo 'Original Array :';
print_r ($originalArray);

echo "<br>";

$rotatedArray = FindRotateArray($originalArray);
echo 'Rotated Arrary :';
print_r ($rotatedArray);

?>
