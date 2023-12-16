<?

$lines = file('input.txt', FILE_IGNORE_NEW_LINES);

// part 1
$part = 1;
foreach($lines as $line) {
	if($line == '')
		$part = 2;
	elseif($part == 1)
		$dots[] = explode(',', $line);
	elseif($part == 2) {
		$fold = sscanf($line, 'fold along %s');
		$folds[] = explode('=', $fold[0]);
	}
}

foreach($folds as $fold) {
	$new_dots = array();
	foreach($dots as $dot) {
		if($fold[0] == 'x') {
			if($dot[0] > $fold[1])
				$dot[0] = $fold[1] - ($dot[0] - $fold[1]);
		} else {
			if($dot[1] > $fold[1])
				$dot[1] = $fold[1] - ($dot[1] - $fold[1]);
		}
		$found = false;
		foreach($new_dots as $ex_dot) {
			if($ex_dot[0] == $dot[0] && $ex_dot[1] == $dot[1])
				$found = true;
		}
		if(!$found)
			$new_dots[] = $dot;
	}
	$dots = $new_dots;
	break;
}

echo count($dots)."\n";

// part 2
foreach($folds as $fold) {
	$new_dots = array();
	foreach($dots as $dot) {
		if($fold[0] == 'x') {
			if($dot[0] > $fold[1])
				$dot[0] = $fold[1] - ($dot[0] - $fold[1]);
		} else {
			if($dot[1] > $fold[1])
				$dot[1] = $fold[1] - ($dot[1] - $fold[1]);
		}
		$found = false;
		foreach($new_dots as $ex_dot) {
			if($ex_dot[0] == $dot[0] && $ex_dot[1] == $dot[1])
				$found = true;
		}
		if(!$found)
			$new_dots[] = $dot;
	}
	$dots = $new_dots;
}

$max_x = 0;
$max_y = 0;
foreach($dots as $dot) {
	if($dot[0] > $max_x)
		$max_x = $dot[0];
	if($dot[1] > $max_y)
		$max_y = $dot[1];
}

$pattern = array_fill(0, $max_y+1, array_fill(0, $max_x+1, ' '));
foreach($dots as $dot)
	$pattern[$dot[1]][$dot[0]] = '#';


foreach($pattern as $line)
	echo implode('', $line)."\n";

?>