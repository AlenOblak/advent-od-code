<?php

$lines = file('input.txt', FILE_IGNORE_NEW_LINES);

$sum = 0;
$cards = array();
$i = 1;
foreach ($lines as $line) {
    $cards[$i] = ($cards[$i] ?? 0) + 1;
    $line = explode('|', $line);
    $win = substr($line[0], strpos($line[0],':')+1);
    $win = explode(' ',trim($win));
    $my = str_replace('  ', ' ', $line[1]);
    $my = explode(' ',trim($my));
    $match_count = count(array_intersect($my, $win));
    // sum for part 1
    if($match_count > 0)
        $sum += pow(2, $match_count - 1);
    // add card for part 2
    for ($j = 1; $j <= $match_count; $j++)
        $cards[$i+$j] = ($cards[$i+$j] ?? 0) + $cards[$i];
    $i++;
}

// part 1
echo $sum."\n";

// part 2
echo array_sum(array_slice($cards, 0, $i))."\n";