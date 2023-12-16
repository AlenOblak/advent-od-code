<?

$lines = file('input.txt', FILE_IGNORE_NEW_LINES);

$pairs = array();
foreach($lines as $line) {
	if($line != '') {
		$p1 = '[[1],[2,3,4]]';
		str_replace('[', 'array(',$line);
		str_replace(']', ']',$line);
		eval('$pair = '.$line.';');
		$pairs[] = $pair;
	}
}

// part 1
$sum = 0;
for($i = 0; $i < count($pairs); $i+=2) {
	$a = $pairs[$i];
	$b = $pairs[$i+1];
	if (which_pair($a, $b) == -1)
		$sum += ($i / 2) + 1;
}

function which_pair($a, $b) {
	if(is_null($a) && is_null($b))
		return 0;
	if(is_int($a) && is_int($b)) {
		if($a > $b)
			return 1;
		if($a < $b)
			return -1;
		return 0;
	}
	if(is_array($a) && is_array($b)) {
		$result = 0;
		while($result == 0) {
			if(count($a) == 0 && count($b) == 0)
				return 0;
			if(count($b) == 0)
				return 1;
			if(count($a) == 0)
				return -1;
			$e1 = array_shift($a);
			$e2 = array_shift($b);
			$result = which_pair($e1, $e2);
		}
		return $result;
	} elseif(is_array($a) && is_int($b)) {
		return which_pair($a, array($b));
	} elseif(is_int($a) && is_array($b)) {
		return which_pair(array($a), $b);
	}
}

echo $sum."\n";

// part 2
$pairs[] = array(array(2));
$pairs[] = array(array(6));
usort($pairs, 'which_pair');
$a = $b = 0;
foreach($pairs as $k => $p) {
	if($p == array(array(2)))
		$a = $k+1;
	if($p == array(array(6)))
		$b = $k+1;
}
echo ($a*$b)."\n";

?>