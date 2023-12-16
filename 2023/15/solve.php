<?php

$lines = file('input.txt', FILE_IGNORE_NEW_LINES);

$seq = explode(',', $lines[0]);

// part 1
echo array_sum(array_map('calc_hash', $seq))."\n";

// part 2
foreach ($seq as $s) {
    if(strpos($s, '=')) {
        $s = explode('=', $s);
        $label = $s[0];
        $lens = $s[1];
        $box[calc_hash($label)][$label] = $lens;
    } else {
        $label = trim($s, '-');
        unset($box[calc_hash($label)][$label]);
    }
}

$sum = 0;
foreach ($box as $i => $b) {
    $j = 1;
    foreach ($b as $v)
        $sum += ($i + 1) * $j++ * $v;
}
echo $sum."\n";

function calc_hash($s)
{
    $hash = 0;
    foreach (str_split($s) as $c)
        $hash = (($hash + ord($c)) * 17) % 256;
    return $hash;
}