<?php

$lines = file('input.txt', FILE_IGNORE_NEW_LINES);

$map = array_map(fn($line) => str_split($line), $lines);

// part 1
echo load(spin_north($map))."\n";

// part 2
$load = array();
for($i = 1; ; $i++) {
    $map = spin($map);
    $num = load($map);
    $hash = sha1(json_encode($map));
    if(array_key_exists($hash, $load)) {
        $cycle = $i - $load[$hash][0];
        break;
    }
    $load[$hash] = array($i, $num);
}

$cycle += (1000000000 % $cycle);
foreach ($load as $l)
    if($l[0] == $cycle)
        echo $l[1]."\n";

function load($map) {
    $sum = 0;
    for ($x = 0; $x < count($map[0]); $x++) {
        $w = count($map);
        for ($y = 0; $y < $w; $y++)
            if($map[$y][$x] == 'O')
                $sum += $w-$y;
    }
    return $sum;
}

function spin ($map) {
    $map = spin_north($map);
    $map = spin_west($map);
    $map = spin_south($map);
    $map = spin_east($map);
    return $map;
}

function spin_north ($map) {
    $new_map = array_fill(0, count($map), array_fill(0, count($map[0]), '.'));
    for ($x = 0; $x < count($map[0]); $x++) {
        $i = 0;
        for ($y = 0; $y < count($map); $y++) {
            if($map[$y][$x] == 'O') {
                $new_map[$i][$x] = 'O';
                $i++;
            } elseif($map[$y][$x] == '#') {
                $new_map[$y][$x] = '#';
                $i = $y+1;
            }
        }
    }
    return $new_map;
}

function spin_west ($map) {
    $new_map = array_fill(0, count($map), array_fill(0, count($map[0]), '.'));
    for ($y = 0; $y < count($map); $y++) {
        $i = 0;
        for ($x = 0; $x < count($map[0]); $x++) {
            if($map[$y][$x] == 'O') {
                $new_map[$y][$i] = 'O';
                $i++;
            } elseif($map[$y][$x] == '#') {
                $new_map[$y][$x] = '#';
                $i = $x+1;
            }
        }
    }
    return $new_map;
}

function spin_east ($map) {
    $new_map = array_fill(0, count($map), array_fill(0, count($map[0]), '.'));
    for ($y = 0; $y < count($map); $y++) {
        $i = count($map[0])-1;
        for ($x = count($map[0])-1; $x >= 0; $x--) {
            if($map[$y][$x] == 'O') {
                $new_map[$y][$i] = 'O';
                $i--;
            } elseif($map[$y][$x] == '#') {
                $new_map[$y][$x] = '#';
                $i = $x-1;
            }
        }
    }
    return $new_map;
}

function spin_south ($map) {
    $new_map = array_fill(0, count($map), array_fill(0, count($map[0]), '.'));
    for ($x = 0; $x < count($map[0]); $x++) {
        $i = count($map)-1;
        for ($y = count($map)-1; $y >= 0; $y--) {
            if($map[$y][$x] == 'O') {
                $new_map[$i][$x] = 'O';
                $i--;
            } elseif($map[$y][$x] == '#') {
                $new_map[$y][$x] = '#';
                $i = $y-1;
            }
        }
    }
    return $new_map;
}