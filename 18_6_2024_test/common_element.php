<?php 
    function FindCommonElemets(array $arr1, array $arr2, array $arr3) : array {
        $i = 0;
        $j = 0;
        $k = 0;
        $result = [];
        $len1 = count($arr1);
        $len2 = count($arr2);
        $len3 = count($arr3);
        while ( $i < $len1 && $j < $len2 && $k < $len3) {
            if ($arr1[$i] === $arr2[$j] && $arr2[$j] === $arr3[$k] ) {
                $result [] = $arr1[$i];
                $i++;
                $j++;
                $k++;
            }else if( $arr1[$i] < $arr2[$j]){
                $i++;                
            }else if( $arr2[$j] < $arr3[$k]){
                $j++;
            }else{
                $k++;
            }
        }
        return $result;
    }
    $arr1 = [1, 5, 10,20,80,  40,];
    $arr2 = [6, 7, 20, 80, 100];
    $arr3 = [3, 4, 15, 20, 30, 70, 80, 120];
    // $arr1 = [1, 2, 2, 3];
    // $arr2 = [2, 2, 3, 4];
    // $arr3 = [2, 3, 3, 5];
    $common = FindCommonElemets($arr1,$arr2,$arr3);

    if (empty($common)) {
        echo 'This arrays are empty.';
    } else {
    foreach($common as $com){
        echo "Common element: " . $com . "<br>";
    }
}  
?>