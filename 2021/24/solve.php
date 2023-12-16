<?

$lines = file('input.txt', FILE_IGNORE_NEW_LINES);

// part 1
foreach($lines as $line)
	$orders[] = explode(' ', $line);

$Zi = array(1,   1,  1, 26,  1,  1,  1, 26,  1, 26,  26,  26,  26, 26);
$Xi = array(10, 12, 15, -9, 15, 10, 14, -5, 14, -7, -12, -10, -1, -11);
$Yi = array(15,  8,  2,  6, 13,  4,  1,  9,  5, 13,   9,   6,  2,   2);

solve(0, '', 0);

function solve($position, $input, $z) {
	global $Xi, $Yi, $Zi, $models;

	if($position == 14) {
		$models[] = $input;
		return;
	}
	if($Zi[$position] == 1) {
		for($i = 1; $i < 10; $i++) {
			$new_z = ($z * 26) + ($i + $Yi[$position]);
			solve($position + 1, $input.$i, $new_z);
		}
	} else {
		$x1 = $z % 26 + $Xi[$position];
		if(0 < $x1 && $x1 < 10) {
			$z = floor($z / 26);
			solve($position + 1, $input.$x1, $z);
		}
	}
}

echo max($models)."\n";
echo min($models)."\n";

?>