<?php

$lines = file('input_small.txt', FILE_IGNORE_NEW_LINES);

$rock = array();
$map = array();
foreach ($lines as $y => $line) {
    foreach (str_split($line) as $x => $c) {
        if($c == '#')
            $rock[$y][$x] = true;
        elseif($c == 'S')
            $map[$y.':'.$x] = true;
    }
}

$max_y = count($lines);
$max_x = strlen($lines[0]);

$map1 = array();
$map2 = $map;

// part 1
$sum1 = 1;
$sum2 = 0;
for($i = 1; $i <= 64; $i++) {
    $step = step();
    if($i % 2 == 0) {
        $sum1 += $step;
        echo $i.' '.$step.' '.$sum1."\n";
    } else {
        $sum2 += $step;
        echo $i.' '.$step.' '.$sum2."\n";
    }
}

function step() {
    global $rock, $map1, $map2, $max_x, $max_y;

    $new_map = array();

    foreach ($map2 as $p => $v) {
        $p = explode(':', $p);
        if(!isset($rock[($p[0]-1) % $max_y][$p[1] % $max_x]) && !isset($map1[($p[0]-1).':'.$p[1]]))
            $new_map[($p[0]-1).':'.$p[1]] = true;
        if(!isset($rock[($p[0]+1) % $max_y][$p[1] % $max_x]) && !isset($map1[($p[0]+1).':'.$p[1]]))
            $new_map[($p[0]+1).':'.$p[1]] = true;
        if(!isset($rock[$p[0] % $max_y][($p[1]-1)  % $max_x]) && !isset($map1[$p[0].':'.($p[1]-1)]))
            $new_map[$p[0].':'.($p[1]-1)] = true;
        if(!isset($rock[$p[0] % $max_y][($p[1]+1)  % $max_x]) && !isset($map1[$p[0].':'.($p[1]+1)]))
            $new_map[$p[0].':'.($p[1]+1)] = true;
        /*
        if($p[0] > 0 && !isset($rock[$p[0]-1][$p[1]]) && !isset($map1[($p[0]-1).':'.$p[1]]))
            $new_map[($p[0]-1).':'.$p[1]] = true;
        if($p[0] < $max_y-1 && !isset($rock[$p[0]+1][$p[1]]) && !isset($map1[($p[0]+1).':'.$p[1]]))
            $new_map[($p[0]+1).':'.$p[1]] = true;
        if($p[1] > 0 && !isset($rock[$p[0]][$p[1]-1]) && !isset($map1[$p[0].':'.($p[1]-1)]))
            $new_map[$p[0].':'.($p[1]-1)] = true;
        if($p[1] < $max_x-1 && !isset($rock[$p[0]][$p[1]+1]) && !isset($map1[$p[0].':'.($p[1]+1)]))
            $new_map[$p[0].':'.($p[1]+1)] = true;
        */
    }
    $map1 = $map2;
    $map2 = $new_map;

    return count($new_map);
}

