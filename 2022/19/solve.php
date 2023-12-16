<?

$lines = file('input.txt', FILE_IGNORE_NEW_LINES);

foreach($lines as $line) {
	$words = explode(' ', $line);
	$blueprint[] = array($words[6], $words[12], $words[18], $words[21], $words[27], $words[30]);
}

function simulate($blueprint, $minutes, $max_size) {
	// robot: ore, clay, obsidian, geode
	// resource: ore, clay, obsidian, geode
	$state[] = array(1, 0, 0, 0, 0, 0, 0, 0);
	for($i = 1; $i <= $minutes; $i++) {
		$new_state = array();
		foreach($state as $s) {
			// make robot 1
			if($blueprint[0] <= $s[4])
				$new_state[] = array($s[0] + 1, $s[1], $s[2], $s[3], $s[4]+$s[0]-$blueprint[0], $s[5]+$s[1], $s[6]+$s[2], $s[7]+$s[3]);
			// make robot 2
			if($blueprint[1] <= $s[4])
				$new_state[] = array($s[0], $s[1] + 1, $s[2], $s[3], $s[4]+$s[0]-$blueprint[1], $s[5]+$s[1], $s[6]+$s[2], $s[7]+$s[3]);
			// make robot 3
			if($blueprint[2] <= $s[4] && $blueprint[3] <= $s[5])
				$new_state[] = array($s[0], $s[1], $s[2] + 1, $s[3], $s[4]+$s[0]-$blueprint[2], $s[5]+$s[1]-$blueprint[3], $s[6]+$s[2], $s[7]+$s[3]);
			// make robot 4
			if($blueprint[4] <= $s[4] && $blueprint[5] <= $s[6])
				$new_state[] = array($s[0], $s[1], $s[2], $s[3] + 1, $s[4]+$s[0]-$blueprint[4], $s[5]+$s[1], $s[6]+$s[2]-$blueprint[5], $s[7]+$s[3]);
			// do nothing
			$new_state[] = array($s[0], $s[1], $s[2], $s[3], $s[4]+$s[0], $s[5]+$s[1], $s[6]+$s[2], $s[7]+$s[3]);
		}
		$state = optimize($new_state, $max_size);
	}

	$max = 0;
	foreach($state as $s)
		$max = max($max, $s[7]);

	return $max;
}

function optimize($state, $max_size) {
	$new_state = array();
	foreach($state as $s1) {
		$good = true;
		foreach($new_state as $s2) {
			if($s1[0] <= $s2[0] && $s1[1] <= $s2[1] && $s1[2] <= $s2[2] && $s1[3] <= $s2[3] && $s1[4] <= $s2[4] && $s1[5] <= $s2[5] && $s1[6] <= $s2[6] && $s1[7] <= $s2[7] ) {
				$good = false;
				break;
			}
		}
		if($good)
			$new_state[] = $s1;
	}

	if(count($new_state) > $max_size) {
		usort($new_state, 'compare_state');
		$new_state = array_slice($new_state, 0, $max_size);
	}

	return $new_state;
}

function compare_state($s1, $s2) {
	return ($s1[0] + ($s1[1] * 5) + ($s1[2] * 25) + ($s1[3] * 100) + ($s1[7] * 100)) < ($s2[0] + ($s2[1] * 5) + ($s2[2] * 25) + ($s2[3] * 100) + ($s2[7] * 100));
}

// part 1
$sum = 0;
foreach($blueprint as $k => $b) {
	$best = simulate($b, 24, 100);
	$sum += ($k+1) * $best;
}
echo $sum."\n";

// part 2
$sum = 1;
for($i = 0; $i < 3; $i++) {
	$best = simulate($blueprint[$i], 32, 100);
	$sum *= $best;
}
echo $sum."\n";

?>