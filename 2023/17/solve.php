<?php

$lines = file('input.txt', FILE_IGNORE_NEW_LINES);

$map = array_map(fn($line) => str_split($line), $lines);

// part 1
echo calc_moves(1, 3)."\n";
echo calc_moves(4, 10)."\n";

function calc_moves($min_move, $max_move)
{
    global $map;
    $len = count($map);
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
        if(isset($min_map[$path[0]][$path[1]][$path[3]]) && $min_map[$path[0]][$path[1]][$path[3]] < $path[2])
            continue;

        if($path[0] == $len-1 && $path[1] == $len-1)
            return $path[2];

        for($i = $min_move; $i <= $max_move; $i++) {
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
}