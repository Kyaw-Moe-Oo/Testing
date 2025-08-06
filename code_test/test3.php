<?php
function FindReverseArray($arr) {
    if (empty($arr)) {
        return 'Array is Empty';
}
return array_reverse($arr);
}
$arr = [7, 2, 5, 8, 10, 1, 6];
$result = FindReverseArray($arr);
echo 'Default Reverse : ';
print_r($result);
?>