<?

$lines = file('input.txt', FILE_IGNORE_NEW_LINES);

foreach($lines as $line)
	$cube[] = explode(',', $line);

$sides = 0;
$min_x = $min_y = $min_z = PHP_INT_MAX;
$max_x = $max_y = $max_z = -PHP_INT_MAX;

foreach($cube as $c) {
	$min_x = min($min_x, $c[0]);
	$min_y = min($min_y, $c[1]);
	$min_z = min($min_z, $c[2]);
	$max_x = max($max_x, $c[0]);
	$max_y = max($max_y, $c[1]);
	$max_z = max($max_z, $c[2]);
	
	$sides += 6;
	foreach($cube as $n) {
		if($c == $n)
			continue;
		if($c[0] == $n[0] && $c[1] == $n[1] && abs($c[2] - $n[2]) == 1)
			$sides--;
		elseif($c[0] == $n[0] && abs($c[1] - $n[1]) == 1 &&$c[2] == $n[2])
			$sides--;
		elseif(abs($c[0] - $n[0]) == 1 && $c[1] == $n[1] && $c[2] == $n[2])
			$sides--;
	}
}

// part 1
echo $sides."\n";

// part 2
$check = array(array($min_x, $min_y, $min_z));
$air = array(array($min_x, $min_y, $min_z));
while(count($check) > 0) {
	$a = array_pop($check);
	if($a[0] < $max_x) {
		$try = array($a[0] + 1, $a[1], $a[2]);
		if(!in_array($try, $air) && !in_array($try, $cube)) {
			$air[] = $try;
			$check[] = $try;
		}
	}
	if($a[0] > $min_x) {
		$try = array($a[0] - 1, $a[1], $a[2]);
		if(!in_array($try, $air) && !in_array($try, $cube)) {
			$air[] = $try;
			$check[] = $try;
		}
	}
	//
	if($a[1] < $max_y) {
		$try = array($a[0], $a[1] + 1, $a[2]);
		if(!in_array($try, $air) && !in_array($try, $cube)) {
			$air[] = $try;
			$check[] = $try;
		}
	}
	if($a[1] > $min_y) {
		$try = array($a[0], $a[1] - 1, $a[2]);
		if(!in_array($try, $air) && !in_array($try, $cube)) {
			$air[] = $try;
			$check[] = $try;
		}
	}
	if($a[2] < $max_z) {
		$try = array($a[0], $a[1], $a[2] + 1);
		if(!in_array($try, $air) && !in_array($try, $cube)) {
			$air[] = $try;
			$check[] = $try;
		}
	}
	if($a[2] > $min_z) {
		$try = array($a[0], $a[1], $a[2] - 1);
		if(!in_array($try, $air) && !in_array($try, $cube)) {
			$air[] = $try;
			$check[] = $try;
		}
	}
}

$sides = 0;
foreach($cube as $c) {
	foreach($air as $n) {
		if($c[0] == $n[0] && $c[1] == $n[1] && abs($c[2] - $n[2]) == 1)
			$sides++;
		elseif($c[0] == $n[0] && abs($c[1] - $n[1]) == 1 &&$c[2] == $n[2])
			$sides++;
		elseif(abs($c[0] - $n[0]) == 1 && $c[1] == $n[1] && $c[2] == $n[2])
			$sides++;
	}
	if($c[0] == $min_x || $c[0] == $max_x)
		$sides++;
	elseif($c[1] == $min_y || $c[1] == $max_y)
		$sides++;
	elseif($c[2] == $min_z || $c[2] == $max_z) 
		$sides++;
}

echo $sides."\n";


?>