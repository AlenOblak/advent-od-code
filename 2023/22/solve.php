<?php

$lines = file('input.txt', FILE_IGNORE_NEW_LINES);

// parse input
$brick = array();
foreach ($lines as $line) {
    $line = explode('~', $line);
    $a = explode(',', $line[0]);
    $b = explode(',', $line[1]);
    $brick[] = array(array(intval($a[0]), intval($a[1]), intval($a[2])), array(intval($b[0]), intval($b[1]), intval($b[2])));
}

// connect bricks up/down
foreach ($brick as $i => $b1) {
    foreach ($brick as $j => $b2) {
        if($i != $j) {
            if((($b2[0][0] <= $b1[0][0] && $b1[0][0] <= $b2[1][0]) || ($b2[0][0] <= $b1[1][0] && $b1[1][0] <= $b2[1][0]) || ($b1[0][0] <= $b2[0][0] && $b2[0][0] <= $b1[1][0]) || ($b1[0][0] <= $b2[1][0] && $b2[1][0] <= $b1[1][0])))
            {
                if((($b2[0][1] <= $b1[0][1] && $b1[0][1] <= $b2[1][1]) || ($b2[0][1] <= $b1[1][1] && $b1[1][1] <= $b2[1][1]) || ($b1[0][1] <= $b2[0][1] && $b2[0][1] <= $b1[1][1]) || ($b1[0][1] <= $b2[1][1] && $b2[1][1] <= $b1[1][1])))
                {
                    if($b2[1][2] < $b1[0][2]) {
                        $brick[$j][3][] = $i; // up
                        $brick[$i][4][] = $j; // down
                    }
                }
            }
        }
    }
}

// part 1
move_all_down(-1);
$count = 0;
for($i = 0; $i < count($brick); $i++) {
    if(any_move($i) == 0)
        $count++;
}
echo $count."\n";

// part 2
$count = 0;
$orig_brick = $brick;
for($i = 0; $i < count($brick); $i++) {
    $brick = $orig_brick;
    $count += move_all_down($i);
}
echo $count."\n";

// move all down
function move_all_down($special) {
    global $brick;

    $moved = array();
    $move = true;
    while ($move) {
        $move = false;
        foreach ($brick as $i => $b1) {
            if($b1[0][2] != 1 && $i != $special) {
                $move_down = 0;
                if(!isset($b1[4]) || (count($b1[4]) == 1 && $b1[4][0] == $special)) {
                    $move_down = 1;
                } else {
                    foreach ($b1[4] as $j) {
                        $b2 = $brick[$j];
                        if($b2[1][2] < $b1[0][2] && $j != $special)
                            $move_down = max($move_down, $b2[1][2] + 1);
                    }
                }
                if($move_down != 0 && $move_down < $b1[0][2]) {
                    $diff = $b1[0][2] - $move_down;
                    $brick[$i][0][2] -= $diff;
                    $brick[$i][1][2] -= $diff;
                    $move = true;
                    $moved[$i] = true;
                }
            }
        }
    }
    return count($moved);
}

function any_move($special) {
    global $brick;

    $move = true;
    while ($move) {
        $move = false;
        foreach ($brick as $i => $b1) {
            if($i != $special && $b1[0][2] != 1) {
                $one_move = true;
                foreach ($b1[4] as $j) {
                    $b2 = $brick[$j];
                    if($j != $special && $i != $j) {
                        if($b2[1][2]+1 == $b1[0][2]) {
                            $one_move = false;
                            break;
                        }
                    }
                }
                if($one_move)
                    return 1;
            }
        }
    }
    return 0;
}