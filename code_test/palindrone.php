<?php
    function IsPalindrone(string  $str) : bool {
        $cleanStr = preg_replace('/[^A-Za-z0-9]/','', $str);
        $cleanStr = strtolower($cleanStr);
        $left = 0;
        $right = strlen($cleanStr) - 1;
        while ($left < $right) {
            if ($cleanStr[$left] !== $cleanStr[$right]) {
                return false;
            }
            $left++;
            $right--;
        }
        return true;
    }

    $testing = "12321";
    if (IsPalindrone($testing)) {
        echo "This is Palindrone ";
    }else{
        echo "This is not Palindrone";
    }
?>