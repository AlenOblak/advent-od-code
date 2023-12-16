<?

$lines = file('input.txt', FILE_IGNORE_NEW_LINES);

foreach($lines as $line) {
	if(strpos($line, '[') !== false)
		$crates[] = $line;
	if(strpos($line, 'move') !== false)
		$order[] = $line;
}

$total_crates = (strlen($crates[0]) + 1) / 4;
for($i = 1; $i <= $total_crates; $i++) {
	for($j = count($crates); $j > 0; $j--) {
		if(substr($crates[$j-1], ($i - 1) * 4 + 1, 1) != ' ')
			$arr[$i][count($crates)-$j] = substr($crates[$j-1], ($i - 1) * 4 + 1, 1);
	}
}

$arr_1 = $arr;
$arr_2 = $arr;

// part 1
foreach($order as $o) {
	list($a, $b, $c) = sscanf($o, "move %d from %d to %d");
	for($i = 1; $i <= $a; $i++) {
		$el = array_pop($arr_1[$b]);
		array_push($arr_1[$c], $el);
	}
}

foreach($arr_1 as $a)
	echo $a[count($a)-1];
echo "\n";

// part 2
foreach($order as $o) {
	list($a, $b, $c) = sscanf($o, "move %d from %d to %d");
	$ele = array();
	for($i = 1; $i <= $a; $i++) {
		$el = array_pop($arr_2[$b]);
		array_push($ele, $el);
	}
	for($i = 1; $i <= $a; $i++) {
		$el = array_pop($ele);
		array_push($arr_2[$c], $el);
	}
}

foreach($arr_2 as $a)
	echo $a[count($a)-1];
echo "\n";

?>