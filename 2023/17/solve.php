<?php

$lines = file('input.txt', FILE_IGNORE_NEW_LINES);

$map = array_map(fn($line) => str_split($line), $lines);
$len = count($map);

// part 1
$min_map = array();
$paths[] = array(0, 0, 0, ''); // x, y, price, moves

while(count($paths) > 0) {
    $min = PHP_INT_MAX;
    foreach ($paths as $i => $p) {
        if($p[2] < $min) {
            $min = $p[2];
            $path_i = $i;
        }
    }
    $path = $paths[$path_i];
    unset($paths[$path_i]);

    if($path[0] == $len-1 && $path[1] == $len-1) {
        echo $path[2]."\n";
        break;
    }

    $last_move = substr($path[3], -1);
    $last_two_moves = substr($path[3], -2);
    $last_three_moves = substr($path[3], -3);

    // right
    if($path[1] < $len - 1 && $last_move != 'L' && $last_three_moves != 'RRR' && (!isset($min_map[$path[0]][$path[1]+1][$last_two_moves.'R']) || $min_map[$path[0]][$path[1]+1][$last_two_moves.'R'] > $path[2] + $map[$path[0]][$path[1]+1])) {
        $paths[] = array($path[0], $path[1]+1, $path[2]+$map[$path[0]][$path[1]+1], $last_two_moves.'R');
        $min_map[$path[0]][$path[1]+1][$last_two_moves.'R'] = $path[2] + $map[$path[0]][$path[1]+1];
    }
    if($path[1] > 0 && $last_move != 'R' && $last_three_moves != 'LLL' && (!isset($min_map[$path[0]][$path[1]-1][$last_two_moves.'L']) || $min_map[$path[0]][$path[1]-1][$last_two_moves.'L'] > $path[2] + $map[$path[0]][$path[1]-1])) {
        $paths[] = array($path[0], $path[1]-1, $path[2]+$map[$path[0]][$path[1]-1], $last_two_moves.'L');
        $min_map[$path[0]][$path[1]-1][$last_two_moves.'L'] = $path[2] + $map[$path[0]][$path[1]-1];
    }
    if($path[0] < $len - 1 && $last_move != 'U' && $last_three_moves != 'DDD' && (!isset($min_map[$path[0]+1][$path[1]][$last_two_moves.'D']) || $min_map[$path[0]+1][$path[1]][$last_two_moves.'D'] > $path[2] + $map[$path[0]+1][$path[1]])) {
        $paths[] = array($path[0]+1, $path[1], $path[2]+$map[$path[0]+1][$path[1]], $last_two_moves.'D');
        $min_map[$path[0]+1][$path[1]][$last_two_moves.'D'] = $path[2] + $map[$path[0]+1][$path[1]];
    }
    if($path[0] > 0 && $last_move != 'D' && $last_three_moves != 'UUU' && (!isset($min_map[$path[0]-1][$path[1]][$last_two_moves.'U']) || $min_map[$path[0]-1][$path[1]][$last_two_moves.'U'] > $path[2] + $map[$path[0]-1][$path[1]])) {
        $paths[] = array($path[0]-1, $path[1], $path[2]+$map[$path[0]-1][$path[1]], $last_two_moves.'U');
        $min_map[$path[0]-1][$path[1]][$last_two_moves.'U'] = $path[2] + $map[$path[0]-1][$path[1]];
    }
}

// part 2
$min_map = array();
$paths[] = array(0, 0, 0, ''); // x, y, price, moves
while(count($paths) > 0) {
    $min = PHP_INT_MAX;
    foreach ($paths as $i => $p) {
        if($p[2] < $min) {
            $min = $p[2];
            $path_i = $i;
        }
    }
    $path = $paths[$path_i];
    unset($paths[$path_i]);

    if($path[0] == $len-1 && $path[1] == $len-1) {
        echo $path[2]."\n";
        break;
    }

    for($i = 4; $i <= 10; $i++) {
        if($path[1]+$i < $len && $path[3] != 'L' && $path[3] != 'R') {
            $price = $path[2];
            for($j = 1; $j <= $i; $j++)
                $price += $map[$path[0]][$path[1]+$j];
            if(!isset($min_map[$path[0]][$path[1]+$i]['R']) || $min_map[$path[0]][$path[1]+$i]['R'] > $price) {
                $paths[] = array($path[0], $path[1] + $i, $price, 'R');
                $min_map[$path[0]][$path[1] + $i]['R'] = $price;
            }
        }
        if($path[1]-$i >= 0 && $path[3] != 'R' && $path[3] != 'L') {
            $price = $path[2];
            for($j = 1; $j <= $i; $j++)
                $price += $map[$path[0]][$path[1]-$j];
            if(!isset($min_map[$path[0]][$path[1]-$i]['L']) || $min_map[$path[0]][$path[1]-$i]['L'] > $price) {
                $paths[] = array($path[0], $path[1] - $i, $price, 'L');
                $min_map[$path[0]][$path[1] - $i]['L'] = $price;
            }
        }
        if($path[0]+$i < $len && $path[3] != 'U' && $path[3] != 'D') {
            $price = $path[2];
            for($j = 1; $j <= $i; $j++)
                $price += $map[$path[0]+$j][$path[1]];
            if(!isset($min_map[$path[0]+$i][$path[1]]['D']) || $min_map[$path[0]+$i][$path[1]]['D'] > $price) {
                $paths[] = array($path[0]+$i, $path[1], $price, 'D');
                $min_map[$path[0]+$i][$path[1]]['D'] = $price;
            }
        }
        if($path[0]-$i >= 0 && $path[3] != 'D' && $path[3] != 'U') {
            $price = $path[2];
            for($j = 1; $j <= $i; $j++)
                $price += $map[$path[0]-$j][$path[1]];
            if(!isset($min_map[$path[0]-$i][$path[1]]['U']) || $min_map[$path[0]-$i][$path[1]]['U'] > $price) {
                $paths[] = array($path[0]-$i, $path[1], $price, 'U');
                $min_map[$path[0]-$i][$path[1]]['U'] = $price;
            }
        }
    }
}