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
/*
Wolfram Alpha solver:
Solve[X1 + T1  X2 - 156689809620606 - (-26  T1 ) == 0 &&
X1 + T2 * X2 - 106355761063908 - (T2 * 73) == 0 &&
X1 + T3 * X2 - 271915251832336 - (T3 * 31) == 0 &&
Y1 + T1 * Y2 - 243565579389165 - (T1 * 48) == 0 &&
Y1 + T2 * Y2 - 459832650718033 - (T2 * -206) == 0 &&
Y1 + T3 * Y2 - 487490927073225 - (T3 * -414) == 0 &&
Z1 + T1 * Z2 - 455137247320393 - (T1 * -140) == 0 &&
Z1 + T2 * Z2 - 351953299411025 - (T2 * -52) == 0 &&
Z1 + T3 * Z2 - 398003502953444 - (T3 * -304) == 0,{X1,X2,Y1,Y2,Z1,Z2, T1, T2, T3}, Integers]

X1->446533732372768
X2->-337
Y1->293892176908833
Y2->-6
Z1->180204909018503
Z2->155
T1->931974028142
T2->829702369046
T3->474506740599

X1 446533732372768
Y1 293892176908833
Z1 180204909018503
SUM: 920630818300104

 */


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
