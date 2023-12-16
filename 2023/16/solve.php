<?php

$lines = file('input.txt', FILE_IGNORE_NEW_LINES);

$map = array_map(fn($line) => str_split($line), $lines);
$max_x = count($map[0])-1;
$max_y = count($map)-1;

// part 1
echo calc(array(0, 0, 'R'))."\n";

// part 2
$max_energy = 0;
for ($i = 0; $i <= $max_y; $i++) {
    $max_energy = max($max_energy, calc(array($i, 0, 'R')));
    $max_energy = max($max_energy, calc(array($i, $max_x, 'L')));
}

for ($i = 0; $i <= $max_x; $i++) {
    $max_energy = max($max_energy, calc(array(0, $i, 'D')));
    $max_energy = max($max_energy, calc(array($max_x, $i, 'U')));
}
echo $max_energy."\n";

function calc($node) {
    global $max_x, $max_y, $map;
    $energized = array();
    $visited = array();
    $nodes[] = $node;

    while (count($nodes) > 0) {
        $elem = array_pop($nodes);
        $energized[$elem[0]][$elem[1]] = 1;
        if(array_key_exists($elem[0].'-'.$elem[1].'-'.$elem[2], $visited))
            continue;
        if ($map[$elem[0]][$elem[1]] == '.') {
            if ($elem[2] == 'R' && $elem[1] < $max_x)
                $nodes[] = array($elem[0], $elem[1] + 1, $elem[2]);
            if ($elem[2] == 'L' && $elem[1] > 0)
                $nodes[] = array($elem[0], $elem[1] - 1, $elem[2]);
            if ($elem[2] == 'U' && $elem[0] > 0)
                $nodes[] = array($elem[0] - 1, $elem[1], $elem[2]);
            if ($elem[2] == 'D' && $elem[0] < $max_y)
                $nodes[] = array($elem[0] + 1, $elem[1], $elem[2]);
        }
        if ($map[$elem[0]][$elem[1]] == '|') {
            if (($elem[2] == 'R' || $elem[2] == 'L' ) && $elem[0] < $max_y)
                $nodes[] = array($elem[0]+1, $elem[1], 'D');
            if (($elem[2] == 'R' || $elem[2] == 'L' ) && $elem[0] > 0)
                $nodes[] = array($elem[0]-1, $elem[1], 'U');
            if ($elem[2] == 'U' && $elem[0] > 0)
                $nodes[] = array($elem[0] - 1, $elem[1], $elem[2]);
            if ($elem[2] == 'D' && $elem[0] < $max_y)
                $nodes[] = array($elem[0] + 1, $elem[1], $elem[2]);
        }
        if ($map[$elem[0]][$elem[1]] == '-') {
            if ($elem[2] == 'R' && $elem[1] < $max_x)
                $nodes[] = array($elem[0], $elem[1] + 1, $elem[2]);
            if ($elem[2] == 'L' && $elem[1] > 0)
                $nodes[] = array($elem[0], $elem[1] - 1, $elem[2]);
            if (($elem[2] == 'U' || $elem[2] == 'D' ) && $elem[1] < $max_x)
                $nodes[] = array($elem[0], $elem[1]+1, 'R');
            if (($elem[2] == 'U' || $elem[2] == 'D' ) && $elem[1] > 0)
                $nodes[] = array($elem[0], $elem[1]-1, 'L');
        }
        if ($map[$elem[0]][$elem[1]] == '/') {
            if ($elem[2] == 'R' && $elem[0] > 0)
                $nodes[] = array($elem[0]-1, $elem[1], 'U');
            if ($elem[2] == 'L' && $elem[0] < $max_y)
                $nodes[] = array($elem[0]+1, $elem[1], 'D');
            if ($elem[2] == 'U' && $elem[1] < $max_x)
                $nodes[] = array($elem[0], $elem[1]+1, 'R');
            if ($elem[2] == 'D' && $elem[1] > 0)
                $nodes[] = array($elem[0], $elem[1]-1, 'L');
        }
        if ($map[$elem[0]][$elem[1]] == '\\') {
            if ($elem[2] == 'R' && $elem[0] < $max_y)
                $nodes[] = array($elem[0]+1, $elem[1], 'D');
            if ($elem[2] == 'L' && $elem[0] > 0)
                $nodes[] = array($elem[0]-1, $elem[1], 'U');
            if ($elem[2] == 'U' && $elem[1] > 0)
                $nodes[] = array($elem[0], $elem[1]-1, 'L');
            if ($elem[2] == 'D' && $elem[1] < $max_x)
                $nodes[] = array($elem[0], $elem[1]+1, 'R');
        }
        $visited[$elem[0].'-'.$elem[1].'-'.$elem[2]] = true;
    }
    return array_sum(array_map('array_sum', $energized));
}

