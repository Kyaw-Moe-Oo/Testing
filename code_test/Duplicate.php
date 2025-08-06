<?php
    $arr = [12, 12, 11, 40, 12, 5, 6, 5, 12, 11];
    function FindDuplicatesArray($arr){
        $rep = [];
        $num = count($arr);
        for ( $i = 0; $i < $num - 1; $i++) {
            for ( $j = $i + 1; $j < $num; $j++) {
                if ( $arr[$i] === $arr[$j]) {
                    if (!in_array($arr[$i], $rep)) {
                        $rep[] = $arr[$i]; 
                    }
                    break;
                }
            }
        }
        return $rep;
    }
    $duplicates = FindDuplicatesArray($arr);
    echo 'Original Array : ';
    print_r($arr);
    echo '<br>';
    echo 'Duplicated Found :';
    print_r($duplicates);
?>
