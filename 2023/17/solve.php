<?php

$lines = file('input.txt', FILE_IGNORE_NEW_LINES);

$map = array_map(fn($line) => str_split($line), $lines);

foreach ($lines as $line) {

}

echo $sum."\n";