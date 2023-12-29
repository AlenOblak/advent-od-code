<?php

$lines = file('input.txt', FILE_IGNORE_NEW_LINES);

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

// part 1
echo num_after_steps(64)."\n";

// part 2
$steps = 26501365;
$full_grids = intdiv($steps, $max_y);
$remain_steps = $steps % $max_y;
$num_full_grids = ($full_grids * $full_grids * 2) - $full_grids - $full_grids + 1;

$area_odd = num_after_steps($max_y);
$area_even = num_after_steps($max_y + 1);
$area_odd_corner = $area_odd - num_after_steps(65);
$area_even_corner = $area_even - num_after_steps(64);
$result = (($full_grids + 1) * ($full_grids + 1) * $area_odd) + ($full_grids * $full_grids * $area_even) - (($full_grids + 1) * $area_odd_corner) + ($full_grids  * $area_even_corner);

echo $result."\n";

function num_after_steps($steps) {
    global $map, $map1, $map2;

    $map1 = array();
    $map2 = $map;

    $sum1 = 1;
    $sum2 = 0;
    for($i = 1; $i <= $steps; $i++) {
        $step = step();
        if($i % 2 == 0) {
            $sum1 += $step;
            if($i == $steps)
                return $sum1;
        } else {
            $sum2 += $step;
            if($i == $steps)
                return $sum2;
        }
    }
}

function step() {
    global $rock, $map1, $map2, $max_x, $max_y;

    $new_map = array();

    foreach ($map2 as $p => $v) {
        $p = explode(':', $p);
        if($p[0] > 0 && !isset($rock[$p[0]-1][$p[1]]) && !isset($map1[($p[0]-1).':'.$p[1]]))
            $new_map[($p[0]-1).':'.$p[1]] = true;
        if($p[0] < $max_y-1 && !isset($rock[$p[0]+1][$p[1]]) && !isset($map1[($p[0]+1).':'.$p[1]]))
            $new_map[($p[0]+1).':'.$p[1]] = true;
        if($p[1] > 0 && !isset($rock[$p[0]][$p[1]-1]) && !isset($map1[$p[0].':'.($p[1]-1)]))
            $new_map[$p[0].':'.($p[1]-1)] = true;
        if($p[1] < $max_x-1 && !isset($rock[$p[0]][$p[1]+1]) && !isset($map1[$p[0].':'.($p[1]+1)]))
            $new_map[$p[0].':'.($p[1]+1)] = true;
    }
    $map1 = $map2;
    $map2 = $new_map;

    return count($new_map);
}
