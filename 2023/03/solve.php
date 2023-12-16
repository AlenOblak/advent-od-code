<?php

$lines = file('input.txt', FILE_IGNORE_NEW_LINES);

$numbers = array();
$symbols = array();
$gears = array();
// read numbers, symbols and gears
foreach ($lines as $y => $line) {
    $num = '';
    foreach (str_split($line) as $x => $char) {
        if(is_numeric($char) ) {
            $num .= $char;
        } else {
            if($num !== '') {
                $numbers[] = array($num, $x - strlen($num), $y);
                $num = '';
            }
            if($char !== '.')
                $symbols[$x][$y] = true;
            if($char == '*')
                $gears[$x][$y] = true;
        }
    }
    if($num !== '')
        $numbers[] = array($num, strlen($line) - strlen($num), $y);
}

$sum = 0;
$gears_num = array();
// go through all the numbers and
// for part 1: determine if a symbol is around
// for part 2: assign the number to the gear if a gear is around
foreach ($numbers as $number) {
    $number_near_symbol = false;
    $len = strlen($number[0]);
    // part 1
    // on the left
    if(isset($symbols[$number[1]-1][$number[2]-1]))
        $number_near_symbol = true;
    if(isset($symbols[$number[1]-1][$number[2]]))
        $number_near_symbol = true;
    if(isset($symbols[$number[1]-1][$number[2]+1]))
        $number_near_symbol = true;
    // top and bottom
    for ($i = 0; $i < $len; $i++) {
        if (isset($symbols[$number[1] + $i][$number[2] - 1]))
            $number_near_symbol = true;
        if (isset($symbols[$number[1] + $i][$number[2] + 1]))
            $number_near_symbol = true;
    }
    // on the right
    if(isset($symbols[$number[1]+$len][$number[2]-1]))
        $number_near_symbol = true;
    if(isset($symbols[$number[1]+$len][$number[2]]))
        $number_near_symbol = true;
    if(isset($symbols[$number[1]+$len][$number[2]+1]))
        $number_near_symbol = true;
    if($number_near_symbol)
        $sum += $number[0];
    // part 2
    // on the left
    if(isset($gears[$number[1]-1][$number[2]-1]))
        $gears_num[($number[1]-1).'-'.($number[2]-1)][] = $number[0];
    if(isset($symbols[$number[1]-1][$number[2]]))
        $gears_num[($number[1]-1).'-'.($number[2])][] = $number[0];
    if(isset($symbols[$number[1]-1][$number[2]+1]))
        $gears_num[($number[1]-1).'-'.($number[2]+1)][] = $number[0];
    // top and bottom
    for ($i = 0; $i < $len; $i++) {
        if (isset($symbols[$number[1] + $i][$number[2] - 1]))
            $gears_num[($number[1]+$i).'-'.($number[2]-1)][] = $number[0];
        if (isset($symbols[$number[1] + $i][$number[2] + 1]))
            $gears_num[($number[1]+$i).'-'.($number[2]+1)][] = $number[0];
    }
    // on the right
    if(isset($symbols[$number[1]+$len][$number[2]-1]))
        $gears_num[($number[1]+$len).'-'.($number[2]-1)][] = $number[0];
    if(isset($symbols[$number[1]+$len][$number[2]]))
        $gears_num[($number[1]+$len).'-'.($number[2])][] = $number[0];
    if(isset($symbols[$number[1]+$len][$number[2]+1]))
        $gears_num[($number[1]+$len).'-'.($number[2]+1)][] = $number[0];
}

// part 1 is calculated
echo $sum."\n";

// for part 2 take only gears with two numbers assigned
$sum = 0;
foreach ($gears_num as $g)
    if(count($g) == 2)
        $sum += $g[0] * $g[1];

echo $sum."\n";