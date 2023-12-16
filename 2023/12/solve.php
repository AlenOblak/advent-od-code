<?php

$lines = file('input.txt', FILE_IGNORE_NEW_LINES);

$sum1 = 0;
$sum2 = 0;
$cache = array();
foreach ($lines as $line) {
    // part 1
    $sum1 += calc($line);
    // part 2
    $line_e = explode(' ', $line);
    $arr = $line_e[0];
    $num = $line_e[1];
    $arr = $arr.'?'.$arr.'?'.$arr.'?'.$arr.'?'.$arr;
    $num = $num.','.$num.','.$num.','.$num.','.$num;
    $sum2 += calc($arr.' '.$num);
}
echo $sum1."\n";
echo $sum2."\n";

function calc ($line) {
    global $cache;

    if(array_key_exists($line, $cache))
        return $cache[$line];

    $line_e = explode(' ', $line);
    $springs = trim($line_e[0], '.');
    $groups = explode(',', $line_e[1]);

    // if springs are too short
    if(strlen($springs) < array_sum($groups) + count($groups) - 1) {
        $cache[$line] = 0;
        return $cache[$line];
    }

    // if first spring is ?
    if(substr($springs, 0, 1) == '?') {
        // if there are more springs, replace the spring with . and calculate
        if(strlen($springs) > 1)
            $res1 = calc(substr($springs,1).' '.$line_e[1]);
        else
            $res1 = 0;
        // replace the spring with # and calculate
        $res2 = calc('#'.substr($springs,1).' '.$line_e[1]);
        // return the sum
        $cache[$line] = $res1 + $res2;
        return $cache[$line];
    // if first spring is #
    } else {
        // leftmost springs
        $left = substr($springs, 0, $groups[0]);
        // if this is the last group
        if(count($groups) == 1) {
            if(strpos($left, '.') !== false || strpos(substr($springs, $groups[0]), '#') !== false) {
                // if there is a . in the group or there is a # in remaining group, there is no variant
                $cache[$line] = 0;
            } else {
                // there is one variant
                $cache[$line] = 1;
            }
            return $cache[$line];
        }
        // if there is a . in the group or there is a # in the next spring after the group, there is no variant
        if(strpos($left, '.') !== false || substr($springs, $groups[0], 1) == '#') {
            $cache[$line] = 0;
            return $cache[$line];
        }
        // remove one spring group from the beginning and calculate for the rest of the springs
        $last = array_shift($groups);
        $res = calc(substr($springs, $last+1).' '.implode(',', $groups));
        $cache[$line] = $res;
        return $cache[$line];
    }
}