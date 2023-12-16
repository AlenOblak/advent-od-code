<?

$lines = file('input.txt', FILE_IGNORE_NEW_LINES);

foreach($lines as $x => $line)
	$map[$x] = str_split($line);

// part 1
echo 'min score '.find_min_score($map)."\n";

// part 2
$max_x = count($map) - 1;
$max_y = count($map[0]) - 1;

for($i = 0; $i < 5; $i++)
	for($j = 0; $j < 5; $j++)
		for($x = 0; $x <= $max_x; $x++)
			for($y = 0; $y <= $max_y; $y++) {
				$map[($i*($max_x+1)) + $x][($j*($max_y+1)) + $y] = $map[$x][$y] + $i + $j;
				if($map[($i*($max_x+1)) + $x][($j*($max_y+1)) + $y] > 9)
					$map[($i*($max_x+1)) + $x][($j*($max_y+1)) + $y] -= 9;
			}

echo 'min score '.find_min_score($map)."\n";

function find_min_score($map) {
	$max_x = count($map) - 1;
	$max_y = count($map[0]) - 1;

	for($i = 0; $i <= $max_x; $i++)
		for($j = 0; $j <= $max_y; $j++) {
			$cost[$i][$j] = 0;
			if($j > 0) {
				 if($cost[$i][$j] == 0 || ($cost[$i][$j-1] + $map[$i][$j]) < $cost[$i][$j])
					 $cost[$i][$j] = $cost[$i][$j-1] + $map[$i][$j];
			}
			if($i > 0) {
				 if($cost[$i][$j] == 0 || ($cost[$i-1][$j] + $map[$i][$j]) < $cost[$i][$j])
					 $cost[$i][$j] = $cost[$i-1][$j] + $map[$i][$j];
			}
		}

	$change = true;
	while($change) {
		$change = false;
		for($i = 0; $i <= $max_x; $i++)
			for($j = 0; $j <= $max_y; $j++) {
				if($j > 0) {
					if($cost[$i][$j] == 0 || ($cost[$i][$j-1] + $map[$i][$j]) < $cost[$i][$j]) {
						$cost[$i][$j] = $cost[$i][$j-1] + $map[$i][$j];
						$change = true;
					}
				}
				if($j < $max_y) {
					if($cost[$i][$j] == 0 || ($cost[$i][$j+1] + $map[$i][$j]) < $cost[$i][$j]) {
						$cost[$i][$j] = $cost[$i][$j+1] + $map[$i][$j];
						$change = true;
					}
				}
				if($i > 0) {
					if($cost[$i][$j] == 0 || ($cost[$i-1][$j] + $map[$i][$j]) < $cost[$i][$j]) {
						$cost[$i][$j] = $cost[$i-1][$j] + $map[$i][$j];
						$change = true;
					}
				}
				if($i < $max_x) {
					if($cost[$i][$j] == 0 || ($cost[$i+1][$j] + $map[$i][$j]) < $cost[$i][$j]) {
						$cost[$i][$j] = $cost[$i+1][$j] + $map[$i][$j];
						$change = true;
					}
				}
			}
	}

	$min_score = $cost[$max_x][$max_y];
	return $min_score;
}

?>