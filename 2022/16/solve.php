<?

$lines = file('input.txt', FILE_IGNORE_NEW_LINES);

$valve = array();
foreach($lines as $line) {
	$words = explode(' ', $line);
	$next = array();
	foreach(array_slice($words, 9) as $n)
		$next[] = trim($n, ', ');
	$valve[$words[1]] = array(trim($words[4], 'rate=;'), 0, $next);
}

// part 1
$states = array(array('AA', array(), 0, 0));
for($i = 1; $i <= 30; $i++) {
	$new_states = array();
	foreach($states as $s) {
		// dont move
		$new_states[] = array($s[0], $s[1], $s[2] + $s[3], $s[3]);
		// open
		if($valve[$s[0]][0] > 0 && !in_array($s[0], $s[1])) {
			$new_open = array_merge($s[1], array($s[0]));
			sort($new_open);
			$new_states[] = array($s[0], $new_open, $s[2] + $s[3], $s[3] + $valve[$s[0]][0]);
		}
		// move
		foreach($valve[$s[0]][2] as $next)
			$new_states[] = array($next, $s[1], $s[2] + $s[3], $s[3]);
	}
	$states = optimize_states($new_states);
}

$max = 0;
foreach($states as $s)
	$max = max($max, $s[2]);

echo $max."\n";

function optimize_states($states) {
	$new_states = array();
	foreach($states as $s) {
		$is_ok = true;
		$delete_state = array();
		foreach($new_states as $i => $new) {
			if($new[0] == $s[0] && $new[2] >= $s[2] && $new[3] >= $s[3])
				$is_ok = false;
			if($new[0] == $s[0] && (($new[2] < $s[2] && $new[3] == $s[3]) || ($new[2] == $s[2] && $new[3] < $s[3])))
				$delete_state[] = $i;
		}
		foreach($delete_state as $d)
			unset($new_states[$d]);
		if($is_ok)
			$new_states[] = $s;
	}
	return $new_states;
}

// part 2
$states = array(array('AA', 'AA', array(), 0, 0));
for($i = 1; $i <= 26; $i++) {
	$new_states = array();
	// player
	foreach($states as $s) {
		// dont move
		$new_states[] = array($s[0], $s[1], $s[2], $s[3] + $s[4], $s[4]);
		// open
		if($valve[$s[0]][0] > 0 && !in_array($s[0], $s[2])) {
			$new_open = array_merge($s[2], array($s[0]));
			sort($new_open);
			$new_states[] = array($s[0], $s[1], $new_open, $s[3] + $s[4], $s[4] + $valve[$s[0]][0]);
		}
		// move
		foreach($valve[$s[0]][2] as $next)
			$new_states[] = array($next, $s[1], $s[2], $s[3] + $s[4], $s[4]);
	}
	$states = optimize_states_2($new_states);
	$new_states = array();
	// elephant
	foreach($states as $s) {
		// dont move
		$new_states[] = array($s[0], $s[1], $s[2], $s[3], $s[4]);
		// open
		if($valve[$s[1]][0] > 0 && !in_array($s[1], $s[2])) {
			$new_open = array_merge($s[2], array($s[1]));
			sort($new_open);
			$new_states[] = array($s[0], $s[1], $new_open, $s[3], $s[4] + $valve[$s[1]][0]);
		}
		// move
		foreach($valve[$s[1]][2] as $next)
			$new_states[] = array($s[0], $next, $s[2], $s[3], $s[4]);
	}
	$states = optimize_states_2($new_states);
}

$max = 0;
foreach($states as $s)
	$max = max($max, $s[3]);

echo $max."\n";

function optimize_states_2($states) {
	$new_states = array();
	foreach($states as $s) {
		$is_ok = true;
		$delete_state = array();
		foreach($new_states as $i => $new) {
			if((($new[0] == $s[0] && $new[1] == $s[1]) || ($new[0] == $s[1] && $new[1] == $s[0])) && $new[3] >= $s[3] && $new[4] >= $s[4])
				$is_ok = false;
			if((($new[0] == $s[0] && $new[1] == $s[1]) || ($new[0] == $s[1] && $new[1] == $s[0])) && (($new[3] < $s[3] && $new[4] == $s[4]) || ($new[3] == $s[3] && $new[4] < $s[4]) || ($new[3] < $s[3] && $new[4] < $s[4])))
				$delete_state[] = $i;
		}
		foreach($delete_state as $d)
			unset($new_states[$d]);
		if($is_ok)
			$new_states[] = $s;
	}
	return $new_states;
}

?>