<?php

$lines = file('input.txt');

// part 1
$number = 0;
for ($i = 1; $i < count($lines); $i++) 
	if(intval($lines[$i-1]) < intval($lines[$i]))
		$number++;
echo $number."\n";

// part 2
$number = 0;
for ($i = 3; $i < count($lines); $i++)
	if(intval($lines[$i-3]) < intval($lines[$i]))
		$number++;
echo $number."\n";