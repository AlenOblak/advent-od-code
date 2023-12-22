<?php

$lines = file('input.txt', FILE_IGNORE_NEW_LINES);

// parse input
$brick = array();
foreach ($lines as $line) {
    $line = explode('~', $line);
    $a = explode(',', $line[0]);
    $b = explode(',', $line[1]);
    $brick[] = array($a, $b);
}

// move all down
$move = true;
while ($move) {
    $move = false;
    foreach ($brick as $i => $b1) {
        if($b1[0][2] != 1) {
            $one_move = true;
            foreach ($brick as $j => $b2) {
                if($i != $j) {
                    for($x = $b1[0][0]; $x <= $b1[1][0]; $x++) {
                        for($y = $b1[0][1]; $y <= $b1[1][1]; $y++) {
                            if($b2[0][0] <= $x && $x <= $b2[1][0] && $b2[0][1] <= $y && $y <= $b2[1][1] && $b2[1][2] == $b1[0][2] - 1) {
                                $one_move = false;
                                break 3;
                            }
                        }
                    }
                }
            }
            if($one_move) {
                $move = true;
                $brick[$i][0][2]--;
                $brick[$i][1][2]--;
            }
        }
    }
}

echo 'moved all down '."\n";
//print_r($brick);

$count = 0;
for($i = 0; $i < count($brick); $i++) {
    if(any_move($i) == 0)
        $count++;
    echo $i.' '.$count."\n";
}
echo $count;

function any_move($special) {
    global $brick;

    $move = true;
    while ($move) {
        $move = false;
        foreach ($brick as $i => $b1) {
            if($i != $special && $b1[0][2] != 1) {
                $one_move = true;
                foreach ($brick as $j => $b2) {
                    if($j != $special && $i != $j) {
                        for($x = $b1[0][0]; $x <= $b1[1][0]; $x++) {
                            for($y = $b1[0][1]; $y <= $b1[1][1]; $y++) {
                                if($b2[0][0] <= $x && $x <= $b2[1][0] && $b2[0][1] <= $y && $y <= $b2[1][1] && $b2[1][2] == $b1[0][2] - 1) {
                                    $one_move = false;
                                    break 3;
                                }
                            }
                        }
                    }
                }
                if($one_move) {
                    return 1;
                }
            }
        }
    }
    return 0;
}