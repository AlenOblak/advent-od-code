<?php

$lines = file('input.txt', FILE_IGNORE_NEW_LINES);

$map = array();
$positions = array();
foreach ($lines as $line) {
    $map[] = str_split($line);
}
$max_y = count($map);
$max_x = count($map[0]);

// part 1
$res = 0;
for($i = 1; $i <= 64;$i++)
    $res = step();
echo $res."\n";

function step() {
    global $map, $max_x, $max_y;

    $new_map = array();
    $pos = array();
    foreach ($map as $y => $line) {
        foreach ($line as $x => $c){
            if($c == '#')
                $new_map[$y][$x] = '#';
            if($c == 'S' || $c == 'O')
                $pos[] = array($y, $x);
        }
    }

    foreach ($pos as $p) {
        if($p[0] > 0 && (!isset($new_map[$p[0]-1][$p[1]]) || $new_map[$p[0]-1][$p[1]] != '#'))
            $new_map[$p[0]-1][$p[1]] = 'O';
        if($p[0] < $max_y-1 && (!isset($new_map[$p[0]+1][$p[1]]) || $new_map[$p[0]+1][$p[1]] != '#'))
            $new_map[$p[0]+1][$p[1]] = 'O';
        if($p[1] > 0 && (!isset($new_map[$p[0]][$p[1]-1]) || $new_map[$p[0]][$p[1]-1] != '#'))
            $new_map[$p[0]][$p[1]-1] = 'O';
        if($p[1] < $max_x-1 && (!isset($new_map[$p[0]][$p[1]+1]) || $new_map[$p[0]][$p[1]+1] != '#'))
            $new_map[$p[0]][$p[1]+1] = 'O';
    }
    $map = $new_map;

    $count = 0;
    foreach ($new_map as $y => $line) {
        foreach ($line as $x => $c){
            if($c == 'O')
                $count++;
        }
    }
    return $count;
}

exit;
// part 2 - not done

$res = 0;
for($i = 1; $i <= 64;$i++){
    $res = step2();
    printmap();
    echo $i.' '.$res."\n";
}

function step2() {
    global $map, $max_x, $max_y;
    global $positions;

    $new_map = array();
    foreach ($map as $y => $line) {
        foreach ($line as $x => $c){
            if($c == '#')
                $new_map[$y][$x] = '#';
            if($c == 'S')
                $positions[$y][$x] = 1;
        }
    }

    $new_positions = array();
    foreach ($positions as $y => $p) {
        foreach ($p as $x => $num) {
            //
            if($y > 0 && (!isset($new_map[$y-1][$x]) || $new_map[$y-1][$x] != '#'))
                $new_positions[$y-1][$x] = max($new_positions[$y-1][$x] ?? 0, $num);
            if($y == 0 && (!isset($new_map[$max_y-1][$x]) || $new_map[$max_y-1][$x] != '#'))
                $new_positions[$max_y-1][$x] = ($new_positions[$max_y-1][$x] ?? 0) + 1;
            //
            if($y < $max_y-1 && (!isset($new_map[$y+1][$x]) || $new_map[$y+1][$x] != '#'))
                $new_positions[$y+1][$x] = max($new_positions[$y+1][$x] ?? 0, $num);
            if($y == $max_y-1 && (!isset($new_map[0][$x]) || $new_map[0][$x] != '#'))
                $new_positions[0][$x] = ($new_positions[0][$x] ?? 0) + 1;
            //
            if($x > 0 && (!isset($new_map[$y][$x-1]) || $new_map[$y][$x-1] != '#'))
                $new_positions[$y][$x-1] = max($new_positions[$y][$x-1] ?? 0, $num);
            if($x == 0 && (!isset($new_map[$y][$max_x-1]) || $new_map[$y][$max_x-1] != '#'))
                $new_positions[$y][$max_x-1] = ($new_positions[$y][$max_x-1] ?? 0) + 1;
            //
            if($x < $max_x-1 && (!isset($new_map[$y][$x+1]) || $new_map[$y][$x+1] != '#'))
                $new_positions[$y][$x+1] = max($new_positions[$y][$x+1] ?? 0, $num);
            if($x == $max_x-1 && (!isset($new_map[$y][0]) || $new_map[$y][0] != '#'))
                $new_positions[$y][0] = ($new_positions[$y][0] ?? 0) + 1;
        }
    }

    $map = $new_map;
    $positions = $new_positions;

    $count = 0;
    foreach ($positions as $p) {
        foreach ($p as $num) {
            $count += $num;
        }
    }
    return $count;
}

function printmap()
{
    global $map, $max_y, $max_x, $positions;
    for($y = 0; $y < $max_y; $y++) {
        for($x = 0; $x < $max_x; $x++) {
            if(isset($map[$y][$x]) && $map[$y][$x] == '#')
                echo '#';
            elseif(isset($positions[$y][$x]))
                echo $positions[$y][$x];
            else
                echo '.';
        }
        echo "\n";
    }
    echo "\n";
}



