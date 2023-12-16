<?

$lines = file('input.txt', FILE_IGNORE_NEW_LINES);

// part 1 and 2
foreach($lines as $line)
	$oct[] = str_split($line);
$flashes = 0;

for($step = 0; $step < 400; $step++) {
	// add 1
	for($i = 0; $i < 10; $i++) {
		for($j = 0; $j < 10; $j++) {
			$oct[$i][$j]++;
		}
	}
	// find flashes
	$f = true;
	$flashes_in_step = 0;
	while($f) {
		$f = false;
		for($i = 0; $i < 10; $i++) {
			for($j = 0; $j < 10; $j++) {
				if($oct[$i][$j] > 9) {
					$f = true;
					$flashes++;
					$flashes_in_step++;
					$oct[$i][$j] = -9999999;
					if($i > 0 && $j > 0)
						$oct[$i-1][$j-1]++;
					if($i > 0)
						$oct[$i-1][$j]++;
					if($i > 0 && $j < 9)
						$oct[$i-1][$j+1]++;
					if($j > 0)
						$oct[$i][$j-1]++;
					if($j < 9)
						$oct[$i][$j+1]++;
					if($i < 9 && $j > 0)
						$oct[$i+1][$j-1]++;
					if($i < 9)
						$oct[$i+1][$j]++;
					if($i < 9 && $j < 9)
						$oct[$i+1][$j+1]++;
				}
			}
		}
	}
	
	if($flashes_in_step == 100) {
		echo 'simultaneus in '.($step+1)."\n";
		break;
	}
	
	// set to 0
	for($i = 0; $i < 10; $i++) {
		for($j = 0; $j < 10; $j++) {
			if($oct[$i][$j] < 0)
				$oct[$i][$j] = 0;
		}
	}
}

echo $flashes."\n";

?>