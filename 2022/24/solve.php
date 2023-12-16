<?

$lines = file('input.txt', FILE_IGNORE_NEW_LINES);

$bliz = array();
foreach($lines as $y => $line) {
	foreach(str_split($line) as $x => $char)
		if($char == '<')
			$bliz[] = array('L', $x, $y);
		elseif($char == '>')
			$bliz[] = array('R', $x, $y);
		elseif($char == '^')
			$bliz[] = array('U', $x, $y);
		elseif($char == 'v')
			$bliz[] = array('D', $x, $y);
}
$max_x = strlen($lines[0]);
$max_y = count($lines);

// part 1
$min1 = find_shortest($bliz, 1, 0, $max_x - 2, $max_y - 1);
echo $min1."\n";

// part 2
$min2 = find_shortest($bliz, $max_x - 2, $max_y - 1, 1, 0);
$min3 = find_shortest($bliz, 1, 0, $max_x - 2, $max_y - 1);
echo $min1+$min2+$min3."\n";

function find_shortest(&$bliz, $x1, $y1, $x2, $y2) {
	global $max_x, $max_y;
	$state[] = array($x1, $y1);
	$min = 1;
	while(true) {
		$bliz = new_bliz($bliz);
		$new_state = array();
		foreach($state as $s) {
			$move_left = true;
			$move_right = true;
			$move_up = true;
			$move_down = true;
			$move_none = true;

			if($s[0] <= 1 || $s[1] < 1 || $s[1] == $max_y - 1)
				$move_left = false;
			if($s[0] == $max_x - 2 || $s[1] < 1)
				$move_right = false;
			if($s[1] <= 1 && $s[0] != 1)
				$move_up = false;
			if($s[1] == $max_y - 2 && $s[0] != $max_x - 2)
				$move_down = false;
			if($s[1] == $max_y - 1)
				$move_down = false;

			foreach($bliz as $b) {
				if($b[1] == $s[0] - 1 && $b[2] == $s[1])
					$move_left = false;
				if($b[1] == $s[0] + 1 && $b[2] == $s[1])
					$move_right = false;
				if($b[1] == $s[0] && $b[2] == $s[1] - 1)
					$move_up = false;
				if($b[1] == $s[0] && $b[2] == $s[1] + 1)
					$move_down = false;
				if($b[1] == $s[0] && $b[2] == $s[1])
					$move_none = false;
			}

			if($move_left)
				$new_state[] = array($s[0] - 1, $s[1]);
			if($move_right)
				$new_state[] = array($s[0] + 1, $s[1]);
			if($move_up)
				$new_state[] = array($s[0], $s[1] - 1);
			if($move_down)
				$new_state[] = array($s[0], $s[1] + 1);
			if($move_none)
				$new_state[] = array($s[0], $s[1]);
		}
		$state = array_unique($new_state, SORT_REGULAR);
		if(in_array(array($x2, $y2), $state))
			return $min;
		$min++;
	}
}

function new_bliz($bliz) {
	global $max_x, $max_y;
	$new_bliz = array();
	foreach($bliz as $b) {
		if($b[0] == 'L') {
			if($b[1] > 1)
				$new_bliz[] = array('L', $b[1] - 1, $b[2]);
			else
				$new_bliz[] = array('L', $max_x - 2, $b[2]);
		} elseif($b[0] == 'R') {
			if($b[1] < $max_x - 2)
				$new_bliz[] = array('R', $b[1] + 1, $b[2]);
			else
				$new_bliz[] = array('R', 1, $b[2]);
		} elseif($b[0] == 'U') {
			if($b[2] > 1)
				$new_bliz[] = array('U', $b[1], $b[2] - 1);
			else
				$new_bliz[] = array('U', $b[1], $max_y - 2);
		} elseif($b[0] == 'D') {
			if($b[2] < $max_y - 2)
				$new_bliz[] = array('D', $b[1], $b[2] + 1);
			else
				$new_bliz[] = array('D', $b[1], 1);
		}
	}
	return $new_bliz;
}

?>