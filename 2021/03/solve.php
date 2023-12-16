<?

$lines = file('input.txt');

// part 1
$gamma = '';
$epsilon = '';

for ($i = 0; $i < count($lines); $i++) {
	for($j = 0; $j < 12; $j++) {
		if($lines[$i][$j] == '1')
			$bit[$j]++;
	}
}
for($j = 0; $j < 12; $j++) {
	if($bit[$j] > 500) {
		$gamma .= '1';
		$epsilon .= '0';
	} else {
		$gamma .= '0';
		$epsilon .= '1';
	}
}
echo (bindec($gamma)*bindec($epsilon))."\n";

// part 2
$oxy = filter_number($lines, 1, 0);
$co2 = filter_number($lines, 0, 0);

echo bindec($oxy) * bindec($co2)."\n";

function filter_number($numbers, $type, $position) {
	$num_0 = array();
	$num_1 = array();

	foreach($numbers as $number)
		if($number[$position] == '0')
			$num_0[] = $number;
		else
			$num_1[] = $number;

	if($type == 0)
		if(count($num_0) > count($num_1))
			if(count($num_0) == 1)
				return $num_0[0];
			else
				return filter_number($num_0, $type, $position + 1);
		else
			if(count($num_1) == 1)
				return $num_1[0];
			else
				return filter_number($num_1, $type, $position + 1);
	else
		if(count($num_0) >= count($num_1))
			if(count($num_0) == 1)
				return $num_0[0];
			else
				return filter_number($num_1, $type, $position + 1);
		else
			if(count($num_1) == 1)
				return $num_1[0];
			else
				return filter_number($num_0, $type, $position + 1);
}

?>