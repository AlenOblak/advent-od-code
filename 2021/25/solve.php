<?

$lines = file('input.txt', FILE_IGNORE_NEW_LINES);

// part 1
foreach($lines as $line)
	$map[] = str_split($line);

$x = count($map[0]);
$y = count($map);

$moves = 1;
$step = 0;

while($moves > 0) {
	$moves = 0;
	// move east
	for($i = 0; $i < $y; $i++)
		for($j = 0; $j < $x; $j++)
			if($map[$i][$j] == 'v') {
				$new_map[$i][$j] = 'v';
			} elseif($map[$i][$j] == '.') {
				if($j > 0 && $map[$i][$j-1] == '>') {
					$new_map[$i][$j] = '>';
					$moves++;
				} elseif($j == 0 && $map[$i][$x-1] == '>') {
					$new_map[$i][$j] = '>';
					$moves++;
				} else {
					$new_map[$i][$j] = '.';
				}
			} elseif($map[$i][$j] == '>') {
				if($j < ($x - 1) && $map[$i][$j+1] == '.') {
					$new_map[$i][$j] = '.';
				} elseif($j == ($x - 1) && $map[$i][0] == '.') {
					$new_map[$i][$j] = '.';
				} else {
					$new_map[$i][$j] = '>';
				}
			}
	$map = $new_map;
	
	// move south
	for($i = 0; $i < $y; $i++)
		for($j = 0; $j < $x; $j++)
			if($map[$i][$j] == '>') {
				$new_map[$i][$j] = '>';
			} elseif($map[$i][$j] == '.') {
				if($i > 0 && $map[$i-1][$j] == 'v') {
					$new_map[$i][$j] = 'v';
					$moves++;
				} elseif($i == 0 && $map[$y-1][$j] == 'v') {
					$new_map[$i][$j] = 'v';
					$moves++;
				} else {
					$new_map[$i][$j] = '.';
				}
			} elseif($map[$i][$j] == 'v') {
				if($i < ($y - 1) && $map[$i+1][$j] == '.') {
					$new_map[$i][$j] = '.';
				} elseif($i == ($y - 1) && $map[0][$j] == '.') {
					$new_map[$i][$j] = '.';
				} else {
					$new_map[$i][$j] = 'v';
				}
			}
	$map = $new_map;
	$step++;
}

echo 'step '.$step."\n";

?>