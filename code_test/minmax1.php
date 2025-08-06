<?php
    function findmaxmin($arr=[]){
        if (count($arr)==0){
            return ['max'=> null,'min'=> null];
        }
    
    $maxvalue = $arr[0];
    $minvalue = $arr[0];
    for ($i=1;$i < count($arr);$i++){
        if ($arr[$i] > $maxvalue){
        $maxvalue = $arr[$i];
    }
        if ($arr[$i] < $minvalue){
            $minvalue = $arr[$i];
    }
     
    }
    return ['min'=> $minvalue, 'max'=> $maxvalue];
}
    $array = [7, 2, 5, 8, 10, 1, 6];
    $result = findmaxmin($array);

    echo "Minimum Value: " . $result['min'] . "<br>";
    echo "Maximum Value: " . $result['max'];
?>