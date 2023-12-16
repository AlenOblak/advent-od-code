<?

$lines = file('input.txt', FILE_IGNORE_NEW_LINES);

$hex = $lines[0];
$string = hex_to_bin($hex, 16, 2);

// part 1
$pos = 0;
$sum = 0;
while($pos < strlen($string) - 10) {
	$start = $pos;
	$version = substr($string, $pos, 3);
	$sum += base_convert($version, 2, 10);
	$pos += 3;
	$type = substr($string, $pos, 3);
	$pos += 3;
	$literal = '';
	$length_type = '';
	$length = '';
	$subpackets = '';
	if($type == '100')
	{
		// literal
		$type = 'literal';
		$part = substr($string, $pos, 5);
		$pos += 5;
		$literal = '';
		while($part[0] == '1') {
			$literal .= substr($part, 1);
			$part = substr($string, $pos, 5);
			$pos += 5;
		}
		$literal .= substr($part, 1);
		$literal = base_convert($literal, 2, 10);
	} else {
		// operator
		if($type == '000') $type = 'sum';
		if($type == '001') $type = 'product';
		if($type == '010') $type = 'min';
		if($type == '011') $type = 'max';
		if($type == '101') $type = 'greater';
		if($type == '110') $type = 'less';
		if($type == '111') $type = 'equal';
		$length_type = substr($string, $pos, 1);
		$pos += 1;
		if($length_type == '0') {
			// 15 - length in bits
			$length = base_convert(substr($string, $pos, 15), 2, 10);
			$pos += 15;
		} else {
			// 11 - number of sub-packets
			$subpackets = base_convert(substr($string, $pos, 11), 2, 10);
			$pos += 11;
		}
	}
	$expr[] = array('version' => $version, 'type' => $type, 'literal' => $literal, 'len_type' => $length_type, 'sub_length' => $length, 'sub_num' => $subpackets, 'start' => $start, 'stop' => $pos);
}
echo 'sum = '.$sum."\n";

// part 2

$result = solve_expr($expr);
echo 'expression = '.$result."\n";

function solve_expr(&$expr, $stop_length = 0) {
	if($stop_length > 0 && $expr[0]['start'] >= $stop_length)
		return false;

	$cur_exp = array_shift($expr);
	if($cur_exp == false)
		return false;

	if($cur_exp['type'] == 'literal') {
		return $cur_exp['literal'];
	} else {
		$literals = array();
		if($cur_exp['len_type'] == 0) {
			$literal = solve_expr($expr, $cur_exp['stop'] + $cur_exp['sub_length']);
			while($literal !== false) {
				$literals[] = $literal;
				$literal = solve_expr($expr, $cur_exp['stop'] + $cur_exp['sub_length']);
			}
		} else {
			for($i = 0; $i < $cur_exp['sub_num']; $i++)
				$literals[] = solve_expr($expr);
		}

		if($cur_exp['type'] == 'sum') {
			$value = array_sum($literals);
		} elseif ($cur_exp['type'] == 'product') {
			$value = array_product($literals);
		} elseif ($cur_exp['type'] == 'min') {
			$value = min($literals);
		} elseif ($cur_exp['type'] == 'max') {
			$value = max($literals);
		} elseif ($cur_exp['type'] == 'greater') {
			if($literals[0] > $literals[1])
				$value = 1;
			else
				$value = 0;
		} elseif ($cur_exp['type'] == 'less') {
			if($literals[1] > $literals[0])
				$value = 1;
			else
				$value = 0;
		} elseif ($cur_exp['type'] == 'equal') {
			if($literals[1] == $literals[0])
				$value = 1;
			else
				$value = 0;
		} 
		return $value;
	}
}

function hex_to_bin($string) {
	foreach(str_split($string) as $char) {
		if($char == '0') $return .= '0000';
		if($char == '1') $return .= '0001';
		if($char == '2') $return .= '0010';
		if($char == '3') $return .= '0011';
		if($char == '4') $return .= '0100';
		if($char == '5') $return .= '0101';
		if($char == '6') $return .= '0110';
		if($char == '7') $return .= '0111';
		if($char == '8') $return .= '1000';
		if($char == '9') $return .= '1001';
		if($char == 'A') $return .= '1010';
		if($char == 'B') $return .= '1011';
		if($char == 'C') $return .= '1100';
		if($char == 'D') $return .= '1101';
		if($char == 'E') $return .= '1110';
		if($char == 'F') $return .= '1111';
		
	}
	return $return;
}
?>