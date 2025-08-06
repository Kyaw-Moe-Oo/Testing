<?php
    function Anagram(string $str1, string $str2) : bool {
        if (strlen($str1) !== strlen($str2)) {
            return false;
        }
        $count= [];
        $char1 = str_split($str1);
        foreach($char1 as $ch1){
            $count[$ch1] = ($count[$ch1] ?? 0) + 1;
        }
        $char2 =str_split($str2);
        foreach ($char2 as $ch2){
            if (!isset($count[$ch2]) || $count[$ch2] <= 0) {
                return false;
            }
            $count[$ch2]--;
        }
        return true;
    }
    $teststr1="silent";
    $teststr2="listen";
    if(Anagram($teststr1, $teststr2)){
        echo "They are Anagram.";
    }else{
        echo "They are not Anagram.";
    }
?>