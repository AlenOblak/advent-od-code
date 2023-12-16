<?

$lines = file('input.txt', FILE_IGNORE_NEW_LINES);

list($x1, $x2, $y1, $y2) = sscanf($lines[0], "target area: x=%d..%d, y=%d..%d");

// part 1 & 2
$max_height = 0;
$num_try = 0;
for($x_try = 1; $x_try <= $x2; $x_try++) {
	if(!x_is_ok($x_try, $x1, $x2))
		continue;
	for($y_try = $y1; $y_try < 1000; $y_try++) {
		$height = height($x_try, $y_try);
		if($height !== false) {
			$num_try++;
			if($height > $max_height)
				$max_height = $height;
		}
	}
}

echo $max_height."\n";
echo $num_try."\n";

function x_is_ok($x, $min, $max) {
	$x_pos = 0;
	while($x > 0) {
		$x_pos += $x;
		if($x_pos >= $min && $x_pos <= $max)
			return true;
		$x--;
	}
	return false;
}

function height($x_speed, $y_speed) {
	global $x1, $x2, $y1, $y2;
	$x_pos = 0;
	$y_pos = 0;
	$max_height = $y_pos;
	while($x_pos < $x2 && $y_pos > $y1) {
		$x_pos += $x_speed;
		$y_pos += $y_speed;

		if($y_pos > $max_height)
			$max_height = $y_pos;

		if($x_pos >= $x1 && $x_pos <= $x2 && $y_pos >= $y1 && $y_pos <= $y2)
			return $max_height;
		
		if($x_speed > 0)
			$x_speed -= 1;
		$y_speed -= 1;
	}
	return false;
}

?>