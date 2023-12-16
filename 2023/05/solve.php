<?php

$lines = file('input.txt', FILE_IGNORE_NEW_LINES);

$seeds = array();
$map = array();
$i = 0;
// parse the input
foreach ($lines as $line) {
    if(substr($line, 0, 5) == 'seeds') {
       $seeds = explode(' ', substr($line, 7));
    } elseif(strpos($line, 'map') !== false) {
       $i++;
    } elseif($line !== '') {
        $map[$i][] = explode(' ', $line);
    }
}

// part 1
$min = PHP_INT_MAX;
foreach ($seeds as $seed)
    $min = min($min, calc($seed, $map, 1));
echo $min."\n";

// part 2
$min = PHP_INT_MAX;
for ($i = 0; $i < count($seeds); $i+=2) {
    $seed_range = array(array($seeds[$i], $seeds[$i+1]));

    calc2($seed_range, $map, 1);
    foreach ($seed_range as $seed)
        $min = min($min, $seed[0]);
}
echo $min."\n";

// recursive function for part 1
function calc($seed, $map, $i) {
    $pos = $seed;
    foreach ($map[$i] as $mapper)
        if($seed >= $mapper[1] && $seed < $mapper[1]+$mapper[2])
            $pos = $mapper[0] + ($seed - $mapper[1]);

    if($i == 7)
        return $pos;

    return calc($pos, $map, $i+1);
}

// recursive function for part 2
function calc2(&$seeds, $map, $i) {
    $new_seeds = array();
    $rest_seeds = array();
    foreach ($map[$i] as $mapper) {
        $rest_seeds = array();
        foreach ($seeds as $seed) {
            if($mapper[1] <= $seed[0] && $mapper[1] + $mapper[2] >= $seed[0] + $seed[1]) {
                // when the mapper begins before and ends after
                $new_seeds[] = array($seed[0] - $mapper[1] + $mapper[0], $seed[1]);
            } elseif ($mapper[1] <= $seed[0] && $mapper[1] + $mapper[2] >= $seed[0] && $mapper[1] + $mapper[2] < $seed[0] + $seed[1]) {
                // when the mapper begins before and ends before
                $new_seeds[] = array($seed[0] - $mapper[1] + $mapper[0], ($mapper[1] + $mapper[2]) - ($seed[0]));
                $rest_seeds[] = array($mapper[1] + $mapper[2], ($seed[0] + $seed[1]) - ($mapper[1] + $mapper[2]));
            } elseif ($mapper[1] > $seed[0] && $mapper[1] <= $seed[0] + $seed[1] && $mapper[1] + $mapper[2] >= $seed[0] + $seed[1]) {
                // when the mapper begins after and ends after
                $rest_seeds[] = array($seed[0], $mapper[1] - $seed[0]);
                $new_seeds[] = array($mapper[0], ($seed[1] - $mapper[1] + $seed[0]));
            } elseif ($mapper[1] > $seed[0] && $mapper[1] + $mapper[2] < $seed[0] + $seed[1]) {
                // when the mapper begins after and ends before
                $rest_seeds[] = array($seed[0], $mapper[1] - $seed[0]);
                $new_seeds[] = array($mapper[0], $mapper[2]);
                $rest_seeds[] = array($mapper[1] + $mapper[2], $seed[0] + $seed[1] - ($mapper[1] + $mapper[2]));
            } else {
                // when the mapper doesn't move the seeds
                $rest_seeds[] = $seed;
            }
        }
        $seeds = $rest_seeds;
    }

    $seeds = array_merge($new_seeds, $rest_seeds);

    if($i == 7)
        return;
    else
        calc2($seeds, $map, $i+1);
}