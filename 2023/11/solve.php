<?php

$lines = file('input.txt', FILE_IGNORE_NEW_LINES);

foreach ($lines as $i => $line) {
    foreach (str_split($line) as $j => $s)
        if($s == '#')
            $galaxies[] = array($i, $j);
    if(strpos($line, '#') === false)
        $expand_x[] = $i;
}

for($i = 0; $i < count($lines); $i++) {
    $ex = true;
    for($j = 0; $j < count($lines); $j++)
        if(substr($lines[$j], $i, 1) == '#')
            $ex = false;
    if($ex)
        $expand_y[] = $i;
}

$sum1 = 0;
$sum2 = 0;
$count = count($galaxies);
for ($i = 0; $i < $count; $i++)
    for ($j = $i + 1; $j < $count; $j++) {
        $dist1 = abs($galaxies[$i][0] - $galaxies[$j][0]) + abs($galaxies[$i][1] - $galaxies[$j][1]);
        $dist2 = calc_ex($galaxies[$i][0], $galaxies[$j][0], $expand_x) + calc_ex($galaxies[$i][1], $galaxies[$j][1], $expand_y);
        $sum1 += $dist1 + $dist2;
        $sum2 += $dist1 + $dist2 * 999999;
    }
echo $sum1."\n";
echo $sum2."\n";

function calc_ex($a, $b, $expand) {
    if($a > $b) {
        $c = $a;
        $a = $b;
        $b = $c;
    }
    $result = 0;
    for($i = $a; $i < $b; $i++)
        if(in_array($i, $expand))
            $result++;
    return $result;
}