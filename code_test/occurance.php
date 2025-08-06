<?php
    $arr = [1, 2, 2, 2, 3, 4, 7, 8, 2, 8];
    $target =2;
    function CountFreq( $arr, $target){
        $res = 0;
        for ( $i = 0; $i < count($arr); $i++) {
            if ( $arr[$i] === $target){
                $res++;
            }
        }
        return $res;
    }
    // $startTime = microtime(as_float: true);
    $occurrenceCount = CountFreq( $arr, $target);
    echo "Occurrences of " . $target . " in the array: " . $occurrenceCount . "\n";
    // $endTime = microtime(true);
    // $executionTime = ($endTime - $startTime);
    echo "<br>";
    // echo "Search Time: " . sprintf('%.4f', $executionTime) . " seconds" . "\n";
?>
