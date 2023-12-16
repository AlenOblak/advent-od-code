<?php

$lines = file('input.txt', FILE_IGNORE_NEW_LINES);

// sum for part 1
$sum1 = 0;
// sum for part 2
$sum2 = 0;
foreach ($lines as $l) {
    // determine first and last occurrence for each digit
    for ($i = 1; $i < 10; $i++) {
        // first occurrence - digits
        $num1 = strpos($l, $i);
        if($num1 === false)
            $num1 = 9999;
        $pos_min1[$i] = $num1;
        // first occurrence - text
        $num2 = strpos($l, num_to_text($i));
        if($num2 === false)
            $num2 = 9999;
        $pos_min2[$i] = min($num1, $num2);
        // last occurrence - digits
        $num1 = strrpos($l, $i);
        if($num1 === false)
            $num1 = -1;
        $pos_max1[$i] = $num1;
        // last occurrence - text
        $num2 = strrpos($l, num_to_text($i));
        if($num2 === false)
            $num2 = -1;
        $pos_max2[$i] = max($num1, $num2);
    }

    // determine which digit is first and which is last
    $sum1 += get_first_and_last($pos_min1, $pos_max1);
    $sum2 += get_first_and_last($pos_min2, $pos_max2);
}

echo $sum1."\n";
echo $sum2."\n";

function get_first_and_last($pos_min, $pos_max) {
    $a = '';
    $min = 9999;
    $b = '';
    $max = -1;
    for ($i = 1; $i < 10; $i++) {
        if ($pos_min[$i] < $min) {
            $a = $i;
            $min = $pos_min[$i];
        }
        if ($pos_max[$i] > $max) {
            $b = $i;
            $max = $pos_max[$i];
        }
    }
    return $a.$b;
}

function num_to_text($i) {
    switch ($i) {
        case 1: return 'one';
        case 2: return 'two';
        case 3: return 'three';
        case 4: return 'four';
        case 5: return 'five';
        case 6: return 'six';
        case 7: return 'seven';
        case 8: return 'eight';
        case 9: return 'nine';
    }
}