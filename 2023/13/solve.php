<?php

$lines = file('input.txt', FILE_IGNORE_NEW_LINES);

$patterns = array();
$pattern = array();
foreach ($lines as $line) {
    if($line == '') {
        $patterns[] = $pattern;
        $pattern = array();
    } else {
        $pattern[] = str_split($line);
    }
}
$patterns[] = $pattern;

$sum1 = 0;
$sum2 = 0;
foreach ($patterns as $pattern) {
    $sum1 += calc($pattern, 0);
    $sum2 += calc($pattern, 1);
}
echo $sum1."\n";
echo $sum2."\n";

function calc($pattern, $max_diff)
{
    $x = count($pattern[0]);
    $y = count($pattern);

    // try x
    for($xx = 1; $xx < $x; $xx++) {
        $diff = 0;
        $length = min($xx, $x - $xx);
        for($i = 1; $i <= $length; $i++)
            for($j = 0; $j < $y; $j++) {
                if($pattern[$j][$xx-$i] != $pattern[$j][$xx+$i-1] ) {
                    $diff++;
                    if($diff > $max_diff)
                        break 2;
                }
            }
        if($diff == $max_diff)
            return $xx;
    }

    // try y
    for($yy = 1; $yy < $y; $yy++) {
        $diff = 0;
        $length = min($yy, $y - $yy);
        for($i = 0; $i < $x; $i++)
            for($j = 1; $j <= $length; $j++) {
                if($pattern[$yy-$j][$i] != $pattern[$yy+$j-1][$i] ) {
                    $diff++;
                    if($diff > $max_diff)
                        break 2;
                }
            }
        if($diff == $max_diff)
            return $yy * 100;
    }
}