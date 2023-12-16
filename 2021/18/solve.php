<?

$lines = file('input.txt', FILE_IGNORE_NEW_LINES);

// part 1
$number = $lines[0];
for($i = 1; $i < count($lines); $i++)
	$number = num_add($number, $lines[$i]);
echo num_magnitude($number)."\n";

// part 2
$max_mag = 0;
for($i = 0; $i < count($lines); $i++) {
	for($j = 0; $j < count($lines); $j++) {
		if($i != $j) {
			$mag = num_magnitude(num_add($lines[$i], $lines[$j]));
			if($mag > $max_mag)
				$max_mag = $mag;
		}
	}
}
echo $max_mag."\n";

function num_magnitude($number) {
	while(!is_numeric($number)) {
		for($i = 0; $i < strlen($number); $i++) {
			if($number[$i] == '[')
				$pos_open_tag = $i;
			if($number[$i] == ']') {
				$pair = substr($number, $pos_open_tag+1, $i - $pos_open_tag-1);
				list($a, $b) = sscanf($pair, "%d,%d");
				$left = substr($number, 0, $pos_open_tag);
				$right = substr($number, $i+1);
				$number = $left.(3*$a+2*$b).$right;
				break;
			}
		}
	}
	return $number;
}


function num_add($a, $b) {
	return num_reduce('['.$a.','.$b.']');
}

function num_reduce($number) {
	$old = $number;
	$change = true;
	while($change) {
		$change = false;
		num_explode($number);
		if($old != $number) {
			$change = true;
			$old = $number;
		}
		if(!$change) {
			num_split($number);
			if($old != $number) {
				$change = true;
				$old = $number;
			}
		}
	}
	return $number;
}

function num_split(&$number) {
	$is_num = false;
	for($i = 0; $i <= strlen($number); $i++) {
		if(!$is_num && is_numeric($number[$i])) {
			$start_pos = $i;
			$is_num = true;
		}
		if($is_num && !is_numeric($number[$i])) {
			$value = intval(substr($number, $start_pos, $i - $start_pos));
			if($value > 9) {
				$number = substr($number, 0, $start_pos).'['.floor($value/2).','.ceil($value/2).']'.substr($number, $i);
				return;
			}
			$is_num = false;
		}
	}
}

function num_explode(&$number) {
	$chars = str_split($number);
	foreach($chars as $key => $char) {
		if($char == '[') {
			$level++;
			$pos_open_tag = $key;
		}
		if($char == ']') {
			$level--;
			if($level >= 4) {
				$pair = substr($number, $pos_open_tag+1, $key - $pos_open_tag-1);
				list($a, $b) = sscanf($pair, "%d,%d");
				$left = add_at_right($a, substr($number, 0, $pos_open_tag));
				$right = add_at_left($b, substr($number, $key+1));
				$number = $left.'0'.$right;
				return;
			}
			$pos_close_tag = $key;
		}
	}
}

function add_at_left($num, $number) {
	$is_num = false;
	for($i = 0; $i <= strlen($number); $i++) {
		if(!$is_num && is_numeric($number[$i])) {
			$start_pos = $i;
			$is_num = true;
		}
		if($is_num && !is_numeric($number[$i]))
			return substr($number, 0, $start_pos).(intval(substr($number, $start_pos, $i - $start_pos))+$num).substr($number, $i);
	}
	return $number;
}

function add_at_right($num, $number) {
	$is_num = false;
	for($i = strlen($number); $i >= 0; $i--) {
		if(!$is_num && is_numeric($number[$i])) {
			$start_pos = $i;
			$is_num = true;
		}
		if($is_num && !is_numeric($number[$i]))
			return substr($number, 0, $i+1).(intval(substr($number, $i+1, $start_pos-$i))+$num).substr($number, $start_pos+1);
	}
	return $number;
}

?>