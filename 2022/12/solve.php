<?

$lines = file('input.txt', FILE_IGNORE_NEW_LINES);

$grid = array();
foreach($lines as $line)
	$grid[] = str_split($line);

$x = count($grid);
$y = count($grid[0]);
$price = array_fill(0, $x, array_fill(0, $y, PHP_INT_MAX));
for($i = 0; $i < $x; $i++) {
	for($j = 0; $j < $y; $j++) {
		if($grid[$i][$j] == 'E') {
			$grid[$i][$j] = 'z';
			$E_x = $i;
			$E_y = $j;
		} elseif($grid[$i][$j] == 'S') {
			$grid[$i][$j] = 'a';
			$price[$i][$j] = 0;
		}
	}
}

// part 1
while($price[$E_x][$E_y] == PHP_INT_MAX) {
	for($i = 0; $i < $x; $i++) {
		for($j = 0; $j < $y; $j++) {
			if($i > 0 && ord($grid[$i-1][$j]) + 1 >= ord($grid[$i][$j]))
				$price[$i][$j] = min($price[$i][$j], $price[$i-1][$j] + 1);
			if($i < $x - 1 && ord($grid[$i+1][$j]) + 1 >= ord($grid[$i][$j]))
				$price[$i][$j] = min($price[$i][$j], $price[$i+1][$j] + 1);
			if($j > 0 && ord($grid[$i][$j-1]) + 1 >= ord($grid[$i][$j]))
				$price[$i][$j] = min($price[$i][$j], $price[$i][$j-1] + 1);
			if($j < $y - 1 && ord($grid[$i][$j+1]) + 1 >= ord($grid[$i][$j]))
				$price[$i][$j] = min($price[$i][$j], $price[$i][$j+1] + 1);
		}
	}
}

echo $price[$E_x][$E_y]."\n";

// part 2
for($i = 0; $i < $x; $i++)
	for($j = 0; $j < $y; $j++)
		if($grid[$i][$j] == 'a')
			$price[$i][$j] = 0;
		else
			$price[$i][$j] = PHP_INT_MAX;

for($step = 1; $step < 1000; $step++) {
	for($i = 0; $i < $x; $i++) {
		for($j = 0; $j < $y; $j++) {
			if($i > 0 && ord($grid[$i-1][$j]) + 1 >= ord($grid[$i][$j]))
				$price[$i][$j] = min($price[$i][$j], $price[$i-1][$j] + 1);
			if($i < $x - 1 && ord($grid[$i+1][$j]) + 1 >= ord($grid[$i][$j]))
				$price[$i][$j] = min($price[$i][$j], $price[$i+1][$j] + 1);
			if($j > 0 && ord($grid[$i][$j-1]) + 1 >= ord($grid[$i][$j]))
				$price[$i][$j] = min($price[$i][$j], $price[$i][$j-1] + 1);
			if($j < $y - 1 && ord($grid[$i][$j+1]) + 1 >= ord($grid[$i][$j]))
				$price[$i][$j] = min($price[$i][$j], $price[$i][$j+1] + 1);
		}
	}
}

echo $price[$E_x][$E_y]."\n";

?>