<?php

$lines = file('input.txt', FILE_IGNORE_NEW_LINES);

// init maps for both parts
$x1 = $y1 = $x2 = $y2 = 0;
$map1 = $map2 = array();
$map1[0][0] = '#';
$map2[0][0] = '#';

foreach ($lines as $line) {
    $line = explode(' ', $line);
    // map for part 1
    $dir1 = $line[0];
    $len1 = $line[1];
    if($dir1 == 'R')
        $x1 += $len1;
    elseif ($dir1 == 'L')
        $x1 -= $len1;
    elseif ($dir1 == 'D')
        $y1 += $len1;
    elseif ($dir1 == 'U')
        $y1 -= $len1;
    $map1[$y1][$x1] = '#';
    // map for part 2
    $line[2] = trim($line[2], '#)(');
    $dir2 = substr($line[2], -1);
    $len2 = hexdec(substr($line[2], 0, strlen($line[2])-1));
    if($dir2 == '0')
        $x2 += $len2;
    elseif ($dir2 == '2')
        $x2 -= $len2;
    elseif ($dir2 == '1')
        $y2 += $len2;
    elseif ($dir2 == '3')
        $y2 -= $len2;
    $map2[$y2][$x2] = '#';
}

// calculate area for map1
$count = calc_area($map1);
echo $count."\n";

// calculate area for map2
$count = calc_area($map2);
echo $count."\n";

// main function that does the magic
function calc_area($map) {
    $range = array();
    $count = 0;
    $y = 0;
    ksort($map);
    foreach ($map as $new_y => $line) {
        $line = array_keys($line);
        sort($line);

        for($i = 0; $i < count($range); $i+=2)
            $count += ($range[$i+1] - $range[$i] + 1) * ($new_y - $y - 1);
        $y = $new_y;

        for($i = 0; $i < count($line); $i+=2) {
            if(!in_array($line[$i], $range) && !in_array($line[$i+1], $range)) {
                $range[] = $line[$i];
                $range[] = $line[$i+1];
                sort($range);
                if(array_search($line[$i], $range) % 2 == 1)
                    $count += $line[$i+1] - $line[$i] - 1;
            } elseif(in_array($line[$i], $range) && !in_array($line[$i+1], $range)) {
                $range[array_search($line[$i], $range)] = $line[$i+1];
                if(array_search($line[$i+1], $range) % 2 == 0)
                    $count += $line[$i+1]-$line[$i];
            } elseif(!in_array($line[$i], $range) && in_array($line[$i+1], $range)) {
                $range[array_search($line[$i+1], $range)] = $line[$i];
                if(array_search($line[$i], $range) % 2 == 1)
                    $count += $line[$i+1]-$line[$i];
            } elseif(in_array($line[$i], $range) && in_array($line[$i+1], $range)) {
                if(array_search($line[$i], $range) % 2 == 0)
                    $count += $line[$i+1]-$line[$i]+1;
                unset($range[array_search($line[$i], $range)]);
                unset($range[array_search($line[$i+1], $range)]);
                sort($range);
            }
        }
        for($i = 0; $i < count($range); $i+=2)
            $count += $range[$i+1] - $range[$i] + 1;
    }
    return $count;
}