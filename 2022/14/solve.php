<?

$lines = file('input.txt', FILE_IGNORE_NEW_LINES);

$walls = array();
foreach($lines as $line)
	$walls[] = explode('->', $line);

// find min and max wall position
$min_x = PHP_INT_MAX;
$min_y = 0;
$max_x = $max_y = PHP_INT_MIN;
foreach($walls as $wall) {
	for($i = 0; $i < count($wall); $i++) {
		list($x1, $y1) = explode(',', trim($wall[$i]));
		$min_x = min($min_x, $x1);
		$min_y = min($min_y, $y1);
		$max_x = max($max_x, $x1);
		$max_y = max($max_y, $y1);
	}
}

// generate large enough grid
$grid = array_fill($min_x - $max_y, $max_x + $max_y + 2, array_fill($min_y, $max_y + 4, '.'));

// populate grid with walls
foreach($walls as $wall) {
	for($i = 0; $i < count($wall) - 1; $i++) {
		list($x1, $y1) = explode(',', trim($wall[$i]));
		list($x2, $y2) = explode(',', trim($wall[$i+1]));
		if($x1 > $x2) {
			$a = $x1;
			$x1 = $x2;
			$x2 = $a;
		}
		if($y1 > $y2) {
			$a = $y1;
			$y1 = $y2;
			$y2 = $a;
		}
		for($a = $x1; $a <= $x2; $a++)
			for($b = $y1; $b <= $y2; $b++) {
				$grid[$a][$b] = 'W';
				$min_x = min($min_x, $a);
				$min_y = min($min_y, $b);
				$max_x = max($max_x, $a);
				$max_y = max($max_y, $b);
			}
	}
}

// part 1
$step = 0;
while(true) {
	$sand_x = 500;
	$sand_y = 0;
	while(true) {
		if($grid[$sand_x][$sand_y+1] == '.') {
			$sand_y++;
		} elseif($grid[$sand_x-1][$sand_y+1] == '.') {
			$sand_y++;
			$sand_x--;
		} elseif($grid[$sand_x+1][$sand_y+1] == '.') {
			$sand_y++;
			$sand_x++;
		} else {
			break;
		}
		if($sand_y > $max_y)
			break 2;
	}
	$grid[$sand_x][$sand_y] = 'S';
	$step++;
}
echo $step."\n";

// part 2
while(true) {
	$sand_x = 500;
	$sand_y = 0;
	while($sand_y < $max_y + 1) {
		if($grid[$sand_x][$sand_y+1] == '.') {
			$sand_y++;
		} elseif($grid[$sand_x-1][$sand_y+1] == '.') {
			$sand_y++;
			$sand_x--;
		} elseif($grid[$sand_x+1][$sand_y+1] == '.') {
			$sand_x++;
			$sand_y++;
		} else {
			if($sand_y == 0)
				break 2;
			break;
		}
	}
	$grid[$sand_x][$sand_y] = 'S';
	$step++;
}
echo ($step+1)."\n";

?>