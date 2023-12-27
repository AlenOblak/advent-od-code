<?php

$lines = file('input.txt', FILE_IGNORE_NEW_LINES);

// parse input
$map = array();
foreach ($lines as $line)
    $map[] = str_split($line);

$max_y = count($map) - 1;
$max_x = count($map[0]) - 1;
$start = array(0, 1);
$end = array($max_y, $max_x-1);

// part 1
$max_path = calc_max_path();
echo $max_path."\n";

// part 2
foreach ($map as $y => $line)
    foreach ($line as $x => $c)
        if($map[$y][$x] != '#')
            $map[$y][$x] = '.';
$max_path = calc_max_path_2();
echo $max_path."\n";

function calc_max_path() {
    global $end, $max_x, $max_y, $map;

    $path = array(0, 1, array('0:1'));
    $paths = array($path);
    $max_path = 0;

    while(count($paths)) {
        $path = array_pop($paths);

        // check for end of path
        if($path[0] == $end[0] && $path[1] == $end[1])
            $max_path = max($max_path, count($path[2])-1);

        // right
        if($path[1] < $max_x) {
            $new_y = $path[0];
            $new_x = $path[1]+1;
            if(($map[$new_y][$new_x] == '.' || $map[$new_y][$new_x] == '>') && !in_array($new_y.':'.$new_x, $path[2]))
                $paths[] = array($new_y, $new_x, array_merge($path[2], array($new_y.':'.$new_x)));
        }
        // left
        if($path[1] > 0) {
            $new_y = $path[0];
            $new_x = $path[1]-1;
            if(($map[$new_y][$new_x] == '.' || $map[$new_y][$new_x] == '<') && !in_array($new_y.':'.$new_x, $path[2]))
                $paths[] = array($new_y, $new_x, array_merge($path[2], array($new_y.':'.$new_x)));
        }
        // down
        if($path[0] < $max_y) {
            $new_y = $path[0]+1;
            $new_x = $path[1];
            if(($map[$new_y][$new_x] == '.' || $map[$new_y][$new_x] == 'v') && !in_array($new_y.':'.$new_x, $path[2]))
                $paths[] = array($new_y, $new_x, array_merge($path[2], array($new_y.':'.$new_x)));
        }
        // up
        if($path[0] > 0) {
            $new_y = $path[0]-1;
            $new_x = $path[1];
            if(($map[$new_y][$new_x] == '.' || $map[$new_y][$new_x] == '^') && !in_array($new_y.':'.$new_x, $path[2]))
                $paths[] = array($new_y, $new_x, array_merge($path[2], array($new_y.':'.$new_x)));
        }
    }
    return $max_path;
}

function calc_max_path_2() {
    global $end, $max_x, $max_y, $map;

    // construct graph
    $connections = array();
    $visited = array();
    // x1, y1, x2, y2, visited
    $path = array(0, 1, 0, 1, array('0:1'));
    $paths = array($path);

    while(count($paths)) {
        $path = array_pop($paths);

        $moves = array();
        // right
        if($path[3] < $max_x) {
            $new_y = $path[2];
            $new_x = $path[3]+1;
            if($map[$new_y][$new_x] == '.' && !in_array($new_y.':'.$new_x, $path[4]))
                $moves[] = array($new_y, $new_x);
        }
        // left
        if($path[3] > 0) {
            $new_y = $path[2];
            $new_x = $path[3]-1;
            if($map[$new_y][$new_x] == '.' && !in_array($new_y.':'.$new_x, $path[4]))
                $moves[] = array($new_y, $new_x);
        }
        // down
        if($path[2] < $max_y) {
            $new_y = $path[2]+1;
            $new_x = $path[3];
            if($map[$new_y][$new_x] == '.' && !in_array($new_y.':'.$new_x, $path[4]))
                $moves[] = array($new_y, $new_x);
        }
        // up
        if($path[2] > 0) {
            $new_y = $path[2]-1;
            $new_x = $path[3];
            if($map[$new_y][$new_x] == '.' && !in_array($new_y.':'.$new_x, $path[4]))
                $moves[] = array($new_y, $new_x);
        }

        if(count($moves) == 1) {
            // just longer path
            $paths[] = array($path[0], $path[1], $moves[0][0], $moves[0][1], array_merge($path[4], array($moves[0][0].':'.$moves[0][1])));
        } else {
            // we hit a node
            $connections[] = array($path[0], $path[1], $path[2], $path[3], count($path[4])-1);
            if(!in_array($path[2].':'.$path[3], $visited)) {
                foreach ($moves as $move)
                    $paths[] = array($path[2], $path[3], $move[0], $move[1], array($path[2].':'.$path[3], $move[0].':'.$move[1]));
                $visited[] = $path[2].':'.$path[3];
            }
        }
    }

    // convert connections into nodes with next connections and length
    $nodes = array();
    foreach ($connections as $c) {
        $nodes[$c[0].':'.$c[1]][$c[2].':'.$c[3]] = $c[4];
        $nodes[$c[2].':'.$c[3]][$c[0].':'.$c[1]] = $c[4];
    }

    // search through the graph
    $max_path = 0;
    $path = array('0:1', 0, array('0:1'));
    $paths = array($path);

    while(count($paths)) {
        $path = array_pop($paths);
        if($path[0] == $end[0].':'.$end[1])
            $max_path = max($max_path, $path[1]);

        foreach ($nodes[$path[0]] as $next => $len) {
            if(!in_array($next, $path[2]))
                $paths[] = array($next, $path[1]+$len, array_merge($path[2], array($next)));
        }
    }
    return $max_path;
}