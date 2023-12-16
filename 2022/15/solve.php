<?

$lines = file('input.txt', FILE_IGNORE_NEW_LINES);

$sensor = array();
$min_x = $min_y = PHP_INT_MAX;
$max_x = $max_y = -PHP_INT_MAX;
foreach($lines as $line) {
	$words = explode(' ', $line);
	$a = trim($words[2], 'xy=,');
	$b = trim($words[3], 'xy=:');
	$c = trim($words[8], 'xy=,');
	$d = trim($words[9], 'xy=:');
	$dist = abs($a - $c) + abs($b - $d);
	$min_x = min($min_x, $a - $dist, $c - $dist);
	$min_y = min($min_y, $b - $dist, $d - $dist);
	$max_x = max($max_x, $a + $dist, $c + $dist);
	$max_y = max($max_y, $b + $dist, $d + $dist);
	$sensor[] = array($a, $b, $c, $d, $dist);
}

// part 1
$y = 2000000;
$count = 0;
for($x = $min_x; $x <= $max_x; $x++) {
	foreach($sensor as $s) {
		if($x == $s[2] && $y == $s[3])
			break;
		$dist = abs($x - $s[0]) + abs($y - $s[1]);
		if($dist <= $s[4]) {
			$count++;
			break;
		}
	}
}
echo $count."\n";

// part 2
foreach($sensor as $s) {
	for($x = $s[0] - $s[4] - 1; $x <= $s[0] + $s[4] + 1; $x++) {
		if($x == $s[0] - $s[4] -1 || $x == $s[0] + $s[4] + 1) {
			$y = $s[1];
			check_possible($x, $y);
		} else {
			$dist = $s[4] - abs($x - $s[0]);
			check_possible($x, $s[1] - $dist - 1);
			check_possible($x, $s[1] + $dist + 1);
		}
	}
}

function check_possible($x, $y) {
	global $sensor;
	if($x >= 0 && $x <= 4000000 && $y >= 0 && $y <= 4000000) {
		$block = false;
		foreach($sensor as $s) {
			$dist = abs($x - $s[0]) + abs($y - $s[1]);
			if($dist <= $s[4]) {
				$block = true;
				break;
			}
		}
		if(!$block) {
			echo $x*4000000 + $y."\n";
			exit;
		}
	}
}

?>