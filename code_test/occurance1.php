<?php
function findOccurrences($arr, $target) {
    function findFirst($arr, $target) {
        $low = 0;
        $high = count($arr) - 1;
        $first = -1;

        while ($low <= $high) {
            $mid = floor(($low + $high) / 2);

            if ($arr[$mid] === $target) {
                $first = $mid;
                $high = $mid - 1;
            } elseif ($arr[$mid] < $target) {
                $low = $mid + 1;
            } else {
                $high = $mid - 1;
            }
        }
        return $first;
    }
    function findLast($arr, $target) {
        $low = 0;
        $high = count($arr) - 1;
        $last = -1;

        while ($low <= $high) {
            $mid = floor(($low + $high) / 2);

            if ($arr[$mid] === $target) {
                $last = $mid;
                $low = $mid + 1;
            } elseif ($arr[$mid] < $target) {
                $low = $mid + 1;
            } else {
                $high = $mid - 1;
            }
        }
        return $last;
    }
    $first = findFirst($arr, $target);
    if ($first === -1) {
        return 0;
    }

    $last = findLast($arr, $target);

    return $last - $first + 1;
}
$arr = [1, 1, 2, 2, 2, 2, 3];
$target = 2;
$startTime = microtime(true);
$occurrences = findOccurrences($arr, $target);
$endTime = microtime(true);
$executionTime = ($endTime - $startTime);

echo "Array: ";
print_r($arr);
echo "Target: " . $target . "\n";
echo "Number of occurrences of {$target}: {$occurrences}\n";
echo "Search Time: " . sprintf('%.6f', $executionTime) . " seconds" . "\n";
?>