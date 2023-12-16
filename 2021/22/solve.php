<?
ini_set('memory_limit','1024M');

$lines = file('input.txt', FILE_IGNORE_NEW_LINES);

// part 1
$map = array();
$total_on = 0;
foreach($lines as $line) {
	list($order, $x1, $x2, $y1, $y2, $z1, $z2) = sscanf($line, '%s x=%d..%d,y=%d..%d,z=%d..%d');
	if($x1 >=  -50 && $x1 <= 50)
		for($x = $x1; $x <= $x2; $x++)
			for($y = $y1; $y <= $y2; $y++)
				for($z = $z1; $z <= $z2; $z++)
					if($order == 'on' && $map[$x][$y][$z] == 0) {
						$total_on++;
						$map[$x][$y][$z] = 1;
					} elseif($order == 'off' && $map[$x][$y][$z] == 1) {
						$total_on--;
						$map[$x][$y][$z] = 0;
					}
}
echo $total_on."\n";

// part 2
$cubes = array();
foreach($lines as $line) {
	list($order, $x1, $x2, $y1, $y2, $z1, $z2) = sscanf($line, '%s x=%d..%d,y=%d..%d,z=%d..%d');
	if($order == 'on')
		$sign = 1;
	else
		$sign = -1;

	$cube = array('x1' => $x1, 'x2' => $x2, 'y1' => $y1, 'y2' => $y2, 'z1' => $z1, 'z2' => $z2, 'sign' => $sign);
	$neg_cubes = array();
	foreach($cubes as $c) {
		if($cube['x2'] >= $c['x1'] && $cube['x1'] <= $c['x2'] &&
			$cube['y2'] >= $c['y1'] && $cube['y1'] <= $c['y2'] &&
			$cube['z2'] >= $c['z1'] && $cube['z1'] <= $c['z2'] )
			$neg_cubes[] = array('x1' => max($x1, $c['x1']), 'x2' => min($x2, $c['x2']), 'y1' => max($y1, $c['y1']), 'y2' => min($y2, $c['y2']), 'z1' => max($z1, $c['z1']), 'z2' => min($z2, $c['z2']), 'sign' => -1 * $c['sign']);
	}
	if($order == 'on')
		$cubes[] = $cube;
	$cubes = array_merge($cubes, $neg_cubes);
}

$total_on = 0;
foreach($cubes as $c)
	$total_on += ($c['x2'] - $c['x1'] + 1) * ($c['y2'] - $c['y1'] + 1) * ($c['z2'] - $c['z1'] + 1) * $c['sign'];

echo $total_on."\n";

?>