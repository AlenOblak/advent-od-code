<?php

$lines = file('input.txt', FILE_IGNORE_NEW_LINES);

// part 1
$x = count($lines);
$y = strlen($lines[0]);

foreach($lines as $line) {
	$points[] = str_split($line);
}

$score = 0;
for($i = 0; $i < $x; $i++) {
	for($j = 0; $j < $y; $j++) {
		if($i == 0 || $points[$i][$j] < $points[$i-1][$j])
			if($i == $x - 1 || $points[$i][$j] < $points[$i+1][$j])
				if($j == 0 || $points[$i][$j] < $points[$i][$j-1])
					if($j == $y - 1 || $points[$i][$j] < $points[$i][$j+1])
						$score += $points[$i][$j]+1;
	}
}

echo $score."\n";

// part 2
for($i = 0; $i < $x; $i++) {
	for($j = 0; $j < $y; $j++) {
		if($i == 0 || $points[$i][$j] < $points[$i-1][$j])
			if($i == $x - 1 || $points[$i][$j] < $points[$i+1][$j])
				if($j == 0 || $points[$i][$j] < $points[$i][$j-1])
					if($j == $y - 1 || $points[$i][$j] < $points[$i][$j+1]) {
						// first point of basin
						$basins[] = array($i, $j);
					}
	}
}

foreach($basins as $basin) {
	$points_in = array();
	$points_check[] = $basin[0].'-'.$basin[1];
	while(count($points_check) > 0) {
		$check = explode('-',array_pop($points_check));
		$points_in[] = array($check[0],$check[1]);
		if($check[0] > 0 && $points[$check[0]-1][$check[1]] < 9) {
			$exist = false;
			foreach($points_in as $p)
				if($p[0] == ($check[0]-1) && $p[1] == $check[1])
					$exist = true;
			if(!$exist && !in_array(($check[0]-1).'-'.($check[1]), $points_check))
				$points_check[] = ($check[0]-1).'-'.$check[1];
		}
		if($check[0] < $x - 1 && $points[$check[0]+1][$check[1]] < 9){
			$exist = false;
			foreach($points_in as $p)
				if($p[0] == ($check[0]+1) && $p[1] == $check[1])
					$exist = true;
			if(!$exist && !in_array(($check[0]+1).'-'.($check[1]), $points_check))
				$points_check[] = ($check[0]+1).'-'.$check[1];
		}
		if($check[1] > 0 && $points[$check[0]][$check[1]-1] < 9) {
			$exist = false;
			foreach($points_in as $p)
				if($p[0] == ($check[0]) && $p[1] == $check[1]-1)
					$exist = true;
			if(!$exist && !in_array(($check[0]).'-'.($check[1]-1), $points_check))
				$points_check[] = ($check[0]).'-'.($check[1]-1);
		}
		if($check[1] < $y - 1 && $points[$check[0]][$check[1]+1] < 9) {
			$exist = false;
			foreach($points_in as $p)
				if($p[0] == ($check[0]) && $p[1] == ($check[1]+1))
					$exist = true;
			if(!$exist && !in_array(($check[0]).'-'.($check[1]+1), $points_check))
				$points_check[] = ($check[0]).'-'.($check[1]+1);
		}
	}
	$basin_sizes[] = count($points_in);
}

rsort($basin_sizes, SORT_NUMERIC );

echo $basin_sizes[0]*$basin_sizes[1]*$basin_sizes[2]."\n";