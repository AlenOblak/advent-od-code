<?php

$lines = file('input.txt', FILE_IGNORE_NEW_LINES);

$sum = 0;
foreach ($lines as $line)
    $sum += calc(explode(' ', $line));
echo $sum."\n";

$sum = 0;
foreach ($lines as $line)
    $sum += calc(array_reverse(explode(' ', $line)));
echo $sum."\n";

function calc($numbers)
{
    if(count(array_count_values($numbers)) == 1)
        return $numbers[0];

    $new_numbers = array();
    for($i = 0; $i < count($numbers) - 1; $i++)
        $new_numbers[] = $numbers[$i+1] - $numbers[$i];

    return $numbers[count($numbers) - 1] + calc($new_numbers);
}