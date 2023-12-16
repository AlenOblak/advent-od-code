<?php

$lines = file('input.txt', FILE_IGNORE_NEW_LINES);

$sum1 = 0;
$sum2 = 0;
$i = 1;
foreach ($lines as $l) {
    $game_possible = true;
    $red = $green = $blue = 0;
    $sets = explode('; ', substr($l, strpos($l,':')+2));
    foreach ($sets as $set) {
        $set_ok = true;
        $cubes = explode(', ' , $set);
        foreach ($cubes as $cube) {
            $cube = explode(' ', $cube);
            if($cube[1] == 'red' && $cube[0] > 12)
                $set_ok = false;
            if($cube[1] == 'green' && $cube[0] > 13)
                $set_ok = false;
            if($cube[1] == 'blue' && $cube[0] > 14)
                $set_ok = false;
            if($cube[1] == 'red' && $cube[0] > $red)
                $red = $cube[0];
            if($cube[1] == 'green' && $cube[0] > $green)
                $green = $cube[0];
            if($cube[1] == 'blue' && $cube[0] > $blue)
                $blue = $cube[0];
        }
        if(!$set_ok)
            $game_possible = false;
    }
    if($game_possible)
        $sum1 += $i;
    $sum2 += ($red * $green * $blue);
    $i++;
}

echo $sum1."\n";
echo $sum2."\n";
