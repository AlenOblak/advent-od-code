<?php

$lines = file('input.txt', FILE_IGNORE_NEW_LINES);

$ins = $lines[0];
$nodes = array();
foreach (array_slice($lines, 2) as $line) {
    $line = explode(' ', $line);
    $a = $line[0];
    $b = substr($line[2], 1, 3);
    $c = substr($line[3], 0, 3);
    $nodes[$a] = array($b, $c);
}

// part 1
$i = 0;
$j = 0;
$pos = 'AAA';
while($pos != 'ZZZ') {
    if(substr($ins, $j, 1) == 'R')
        $pos = $nodes[$pos][1];
    else
        $pos = $nodes[$pos][0];
    $i++;
    $j++;
    if($j >= strlen($ins))
        $j = 0;
}

echo $i."\n";

// part 2
$numbers = array();
foreach (array_keys($nodes) as $node) {
    if(substr($node, 2) == 'A') {
        $i = 0;
        $j = 0;
        $pos = $node;
        while(substr($pos, 2) != 'Z') {
            if(substr($ins, $j, 1) == 'R')
                $pos = $nodes[$pos][1];
            else
                $pos = $nodes[$pos][0];
            $i++;
            $j++;
            if($j >= strlen($ins))
                $j = 0;
        }
        $numbers[] = $i;
    }
}

$res = 1;
for($i = 0; $i < count($numbers); $i++)
    $res = lcm($res, $numbers[$i]);
echo $res."\n";

function lcm($a, $b) {
    return $a * $b / gcd($a, $b);
}

function gcd ($a, $b) {
    return $b ? gcd($b, $a % $b) : $a;
}