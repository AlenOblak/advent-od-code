<?

$lines = file('input.txt', FILE_IGNORE_NEW_LINES);

// part 1
$sum = 0;
foreach($lines as $line)
	$sum += decode($line);
echo $sum."\n";

function decode($line) {
	$return = 0;
	$num = 1;

	for($i = strlen($line) - 1; $i >= 0; $i--) {
		$c = substr($line, $i, 1);
		if($c == '2')
			$return += $num * 2;
		elseif($c == '1')
			$return += $num;
		elseif($c == '-')
			$return -= $num;
		elseif($c == '=')
			$return -= $num * 2;
		$num *= 5;
	}

	return $return;
}

// part 2
echo encode($sum)."\n";

function encode($number) {
	$len = 1;
	$total = 0;
	$num = 1;
	$return = '';
	$char = array('=', '-', '0', '1', '2');

	while(true) {
		$total += 2 * $num;
		if($total >= $number)
			break;
		$len++;
		$num *= 5;
	}

	for($pos = $len; $pos > 0; $pos--) {
		$i = 4;
		while($total - $num >= $number) {
			$i--;
			$total -= $num;
		}
		$return .= $char[$i];
		$num /= 5;
	}

	return $return;
}

?>