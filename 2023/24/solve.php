<?php

$lines = file('input.txt', FILE_IGNORE_NEW_LINES);

// parse input
$stone = array();
foreach ($lines as $line) {
    $a = explode(' @ ', $line);
    $stone[] = array(explode(', ', $a[0]), explode(', ', $a[1]));
}

// part 1
$count = 0;
for($i = 0; $i < count($stone) - 1; $i++)
    for($j = $i +1 ; $j < count($stone); $j++)
        if(collide($i, $j, 200000000000000, 400000000000000))
            $count++;
echo $count."\n";

// part 2



function collide($i, $j, $min, $max) {
    global $stone;
    $s1 = $stone[$i];
    $s2 = $stone[$j];

    // if parallel
    if(($s2[1][0] * $s1[1][1] - $s2[1][1] * $s1[1][0]) == 0)
        return 0;

    // calculate the cross point
    $b = ($s2[0][1] * $s1[1][0] - $s1[0][1] * $s1[1][0] + $s1[0][0] * $s1[1][1] - $s2[0][0] * $s1[1][1]) / ($s2[1][0] * $s1[1][1] - $s2[1][1] * $s1[1][0]);
    $a = ($s2[0][1] - $s1[0][1] + $b * $s2[1][1]) / $s1[1][1];
    $x = $s1[0][0] + $a * $s1[1][0];
    $y = $s1[0][1] + $a * $s1[1][1];

    // if not forward
    if($a < 0 || $b < 0)
        return 0;

    // if within the area
    if($min <= $x && $x <= $max )
        if($min <= $y && $y <= $max )
            return 1;

    return 0;
}
