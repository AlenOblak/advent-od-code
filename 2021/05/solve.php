<?

$lines = file('input.txt', FILE_IGNORE_NEW_LINES);

foreach($lines as $line) {
	list($x1, $y1, $x2, $y2) = sscanf($line, "%d,%d -> %d,%d");
	$vents[] = array($x1, $y1, $x2, $y2);
}

$dimension = 1000;
$points = array_fill(0, $dimension, array_fill(0, $dimension, 0));

// part 1
foreach($vents as $vent) {
	if($vent[0] == $vent[2]) {
		for($i = $vent[1]; $i <= $vent[3]; $i++) {
			$points[$vent[0]][$i]++;
		}
		for($i = $vent[3]; $i <= $vent[1]; $i++) {
			$points[$vent[0]][$i]++;
		}
	} elseif($vent[1] == $vent[3]) {
		for($i = $vent[0]; $i <= $vent[2]; $i++) {
			$points[$i][$vent[1]]++;
		}
		for($i = $vent[2]; $i <= $vent[0]; $i++) {
			$points[$i][$vent[1]]++;
		}
	}
}

for($i = 0; $i < $dimension; $i++)
	for($j = 0; $j < $dimension; $j++)
		if($points[$i][$j] > 1)
			$dangers++;

echo $dangers."\n";

// part 2
foreach($vents as $vent) {
	if($vent[0] == $vent[2]) {
		
	} elseif($vent[1] == $vent[3]) {
		
	} else {
		if($vent[0] > $vent[2]) {
			if($vent[1] > $vent[3]) {
				for($i = 0 ; $i <= $vent[0]-$vent[2]; $i++) {
					$points[$vent[0]-$i][$vent[1]-$i]++;
				}
			}
			if($vent[1] < $vent[3]) {
				for($i = 0 ; $i <= $vent[0]-$vent[2]; $i++) {
					$points[$vent[0]-$i][$vent[1]+$i]++;
				}
			}
		}
		if($vent[0] < $vent[2]) {
			if($vent[1] > $vent[3]) {
				for($i = 0 ; $i <= $vent[2]-$vent[0]; $i++) {
					$points[$vent[0]+$i][$vent[1]-$i]++;
				}
			}
			if($vent[1] < $vent[3]) {
				for($i = 0 ; $i <= $vent[2]-$vent[0]; $i++) {
					$points[$vent[0]+$i][$vent[1]+$i]++;
				}
			}
		}
	}
}

$dangers = 0;
for($i = 0; $i < $dimension; $i++)
	for($j = 0; $j < $dimension; $j++)
		if($points[$i][$j] > 1)
			$dangers++;

echo $dangers."\n";

?>
