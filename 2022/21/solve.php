<?

$lines = file('input.txt', FILE_IGNORE_NEW_LINES);

foreach($lines as $line) {
	$words = explode(' ', $line);
	if(count($words) > 2)
		$monkey_op[] = array(trim($words[0], ':'), $words[1], $words[2], $words[3]);
	else
		$monkey_num[] = array(trim($words[0], ':'), $words[1]);
}

// part 1
echo calculate_p1($monkey_op, $monkey_num)."\n";

function calculate_p1($monkey_op, $monkey_num) {
	while(count($monkey_num) > 0) {
		$m = array_pop($monkey_num);
		if($m[0] == 'root')
			return $m[1];
		foreach($monkey_op as $i => $a) {
			if($a[1] == $m[0])
				$monkey_op[$i][1] = $m[1];
			if($a[3] == $m[0])
				$monkey_op[$i][3] = $m[1];
			if(is_numeric($monkey_op[$i][1]) && is_numeric($monkey_op[$i][3])) {
				if($a[2] == '+')
					$monkey_num[] = array($a[0], $monkey_op[$i][1] + $monkey_op[$i][3]);
				if($a[2] == '-')
					$monkey_num[] = array($a[0], $monkey_op[$i][1] - $monkey_op[$i][3]);
				if($a[2] == '*')
					$monkey_num[] = array($a[0], $monkey_op[$i][1] * $monkey_op[$i][3]);
				if($a[2] == '/')
					$monkey_num[] = array($a[0], $monkey_op[$i][1] / $monkey_op[$i][3]);
				unset($monkey_op[$i]);
			}
		}
	}
}

// part 2
$max = 1;
$result = 1;
// bisection first part - determine min and max
while($result > 0) {
	$max *= 10;
	$result = calculate_p2($monkey_op, $monkey_num, $max);
}
$min = $max / 10;

// bisection second part - recursive slice
while($result != 0) {
	$mid = $min + floor(($max - $min) / 2);
	$result = calculate_p2($monkey_op, $monkey_num, $mid);
	if($result < 0)
		$max = $mid;
	else
		$min = $mid;
}

echo $mid."\n";

function calculate_p2($monkey_op, $monkey_num, $my_num) {
	foreach($monkey_num as $i => $a)
		if($a[0] == 'humn')
			$monkey_num[$i][1] = $my_num;
	foreach($monkey_op as $i => $a)
		if($a[0] == 'root')
			$monkey_op[$i][2] = '-';
	
	return calculate_p1($monkey_op, $monkey_num);
}

?>