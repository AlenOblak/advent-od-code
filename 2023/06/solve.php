<?php

$lines = file('input.txt', FILE_IGNORE_NEW_LINES);

$times = array_values(array_filter(explode(' ', $lines[0]), "is_numeric"));
$distances = array_values(array_filter(explode(' ', $lines[1]), "is_numeric"));

// part 1
$product = 1;
for ($i = 0; $i < count($times); $i++)
    $product *= ways_to_win($times[$i], $distances[$i]);
echo $product."\n";

// part 2
$product = ways_to_win(implode($times), implode($distances));
echo $product."\n";

// function to calculate how many ways to win there are
function ways_to_win($time, $dist) {
    $count = 0;
    for($i = 1; $i < $time; $i++)
        if(($i * ($time - $i)) > $dist)
            $count++;
    return $count;
}