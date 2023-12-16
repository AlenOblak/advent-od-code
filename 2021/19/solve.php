<?

$lines = file('input.txt', FILE_IGNORE_NEW_LINES);

// part 1
$scanners = array();
foreach($lines as $line) {
	if(substr($line, 0, 3) == '---') {
		$beacons = array();
	} elseif($line == '') {
		$merged = 'false';
		if(count($scanners) == 0)
			$merged = 'main';
		$scanners[] = array('id' => count($scanners), 'merged' => $merged, 'beacons' => $beacons);
	} else {
		list($a, $b, $c) = sscanf($line, '%d,%d,%d');
		$beacons[] = array($a, $b, $c);
	}
}
if(count($beacons) > 0)
	$scanners[] = array('id' => count($scanners), 'merged' => 'false', 'beacons' => $beacons);

foreach($scanners as $s => $sca) {
	$dist = array();
	foreach($sca['beacons'] as $i => $b1)
		foreach($sca['beacons'] as $j => $b2)
			if($i < $j)
				$dist[] = array($i, $j, dist($b1, $b2));
	$scanners[$s]['distances'] = $dist;
}


$fail = array();
$can_merge = true;
while($can_merge) {
	$can_merge = false;
	$best_score = 0;
	$best_scanner = 0;
	foreach($scanners as $sca) {
		if($sca['merged'] == 'main')
			$origin = $sca;
		elseif($sca['merged'] == 'false' && !in_array($sca['id'], $fail)) {
			$match_score = compare_scanners($origin, $sca);
			if($match_score > $best_score) {
				$best_score = $match_score;
				$best_scanner = $sca['id'];
				$can_merge = true;
			}
		}
	}
	if($can_merge) {
		$merged = merge_scanners($origin['id'], $best_scanner);
		if(!$merged) {
			$fail[] = $best_scanner;
		} else {
			$fail = array();
		}
	}
}
echo 'beacon count '.count($scanners[0]['beacons'])."\n";

// part 2
$max_dist = 0;
foreach($scanners as $sca1)
	foreach($scanners as $sca2) {
		$man_dist = abs($sca1['position'][0] - $sca2['position'][0]) + abs($sca1['position'][1] - $sca2['position'][1]) + abs($sca1['position'][2] - $sca2['position'][2]);
		if($max_dist < $man_dist)
			$max_dist = $man_dist;
	}
echo 'max manhattan distance '.$max_dist."\n";

function merge_scanners($s1, $s2) {
	global $scanners;
	
	foreach($scanners[$s1]['distances'] as $d1)
		foreach($scanners[$s2]['distances'] as $d2)
			if($d1[2] == $d2[2]) {
				$point1 = $scanners[$s1]['beacons'][$d1[0]];
				$point2 = $scanners[$s1]['beacons'][$d1[1]];
				$point3 = $scanners[$s2]['beacons'][$d2[0]];
				$point4 = $scanners[$s2]['beacons'][$d2[1]];
				if(merge_scanners_on_distance($s1, $s2, $d2[0], $d2[1], $point1, $point2, $point3, $point4))
					return true;
			}
	return false;
}

function merge_scanners_on_distance($s1, $s2, $point_1, $point_2, $point1, $point2, $point3, $point4) {
	global $scanners;
	$new_scanner = $scanners[$s2];
	$change = true;
	while($change) {
		$change = false;

		$x1 = $point1[0] - $point2[0];
		$y1 = $point1[1] - $point2[1];
		$z1 = $point1[2] - $point2[2];

		$x2 = $point3[0] - $point4[0];
		$y2 = $point3[1] - $point4[1];
		$z2 = $point3[2] - $point4[2];

		if($x1 == $y2 || $x1 == ($y2 * -1)) {
			$new_scanner = change_scanner_axis($new_scanner, 0, 1, ($x1/$y2));
			$change = true;
		} elseif($y1 == $z2 || $y1 == ($z2 * -1)) {
			$new_scanner = change_scanner_axis($new_scanner, 1, 2, ($y1/$z2));
			$change = true;
		} elseif($x1 == $z2 || $x1 == ($z2 * -1)) {
			$new_scanner = change_scanner_axis($new_scanner, 0, 2, ($x1/$z2));
			$change = true;
		} elseif($x1 == $x2 * -1) {
			$new_scanner = flip_scanner_axis($new_scanner, 0);
			$change = true;
		} elseif($y1 == $y2 * -1) {
			$new_scanner = flip_scanner_axis($new_scanner, 1);
			$change = true;
		} elseif($z1 == $z2 * -1) {
			$new_scanner = flip_scanner_axis($new_scanner, 2);
			$change = true;
		}
		$point3 = $new_scanner['beacons'][$point_1];
		$point4 = $new_scanner['beacons'][$point_2];
	}

	if($x1 == $x2 && $y1 == $y2 && $z1 == $z2) {
		$dx = $point1[0] - $point3[0];
		$dy = $point1[1] - $point3[1];
		$dz = $point1[2] - $point3[2];
		$new_scanner = move_scanner($new_scanner, $dx, $dy, $dz);
	}

	$num_bea = same_beacons_count($scanners[$s1], $new_scanner);
	if($num_bea >= 12) {
		foreach($new_scanner['beacons'] as $b1) {
			$exists = false;
			foreach($scanners[$s1]['beacons'] as $b2)
				if($b1[0] == $b2[0] && $b1[1] == $b2[1] && $b1[2] == $b2[2])
					$exists = true;
			if(!$exists)
				$scanners[$s1]['beacons'][] = array($b1[0], $b1[1], $b1[2]);
		}
		
		$dist = array();
		foreach($scanners[$s1]['beacons'] as $i => $b1)
			foreach($scanners[$s1]['beacons'] as $j => $b2)
				if($i < $j)
					$dist[] = array($i, $j, dist($b1, $b2));
		$scanners[$s1]['distances'] = $dist;
		$scanners[$s2]['merged'] = 'true';
		$scanners[$s2]['position'] = array($dx, $dy, $dz);
		return true;
	} else {
		return false;
	}
}

function same_beacons_count($s1, $s2) {
	$count = 0;
	foreach($s1['beacons'] as $b1)
		foreach($s2['beacons'] as $b2)
			if($b1[0] == $b2[0] && $b1[1] == $b2[1] && $b1[2] == $b2[2])
				$count++;
	return $count;
}

function move_scanner($scanner, $dx, $dy, $dz) {
	foreach($scanner['beacons'] as $key => $bea) {
		$scanner['beacons'][$key][0] += $dx;
		$scanner['beacons'][$key][1] += $dy;
		$scanner['beacons'][$key][2] += $dz;
	}
	return $scanner;
}

function change_scanner_axis($scanner, $axis1, $axis2, $sign) {
	foreach($scanner['beacons'] as $key => $bea) {
		$v1 = $scanner['beacons'][$key][$axis1] * $sign;
		$scanner['beacons'][$key][$axis1] = $scanner['beacons'][$key][$axis2] * $sign;
		$scanner['beacons'][$key][$axis2] = $v1;
	}
	return $scanner;
}

function flip_scanner_axis($scanner, $axis) {
	foreach($scanner['beacons'] as $key => $bea)
		$scanner['beacons'][$key][$axis] = $scanner['beacons'][$key][$axis] * -1;
	return $scanner;
}

function compare_scanners($s1, $s2) {
	$score = 0;
	foreach($s1['distances'] as $d1)
		foreach($s2['distances'] as $d2)
			if($d1[2] == $d2[2])
				$score++;
	return $score;
}

function dist($b1, $b2) {
	$dist = sqrt(($b2[0]-$b1[0])*($b2[0]-$b1[0])+($b2[1]-$b1[1])*($b2[1]-$b1[1])+($b2[2]-$b1[2])*($b2[2]-$b1[2]));
	return $dist;
}

?>