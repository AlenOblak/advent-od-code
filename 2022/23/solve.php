<?

$lines = file('input.txt', FILE_IGNORE_NEW_LINES);

$grid = array();
foreach($lines as $y => $line)
	foreach(str_split($line) as $x => $char)
		if($char == '#')
			$grid[] = array($x, $y);

$direction = 1;
$round = 1;
while(true) {
	$proposed = array();
	foreach($grid as $elf) {
		if(is_elf_alone($elf, $grid)) {
			// nothing
		} elseif($direction == 1) {
			if(can_move_up($elf, $grid))
				add_to_proposed($proposed, $elf[0], $elf[1]-1);
			elseif(can_move_down($elf, $grid))
				add_to_proposed($proposed, $elf[0], $elf[1]+1);
			elseif(can_move_left($elf, $grid)) 
				add_to_proposed($proposed, $elf[0]-1, $elf[1]);
			elseif(can_move_right($elf, $grid))
				add_to_proposed($proposed, $elf[0]+1, $elf[1]);
		} elseif($direction == 2) {
			if(can_move_down($elf, $grid))
				add_to_proposed($proposed, $elf[0], $elf[1]+1);
			elseif(can_move_left($elf, $grid)) 
				add_to_proposed($proposed, $elf[0]-1, $elf[1]);
			elseif(can_move_right($elf, $grid))
				add_to_proposed($proposed, $elf[0]+1, $elf[1]);
			elseif(can_move_up($elf, $grid))
				add_to_proposed($proposed, $elf[0], $elf[1]-1);
		} elseif($direction == 3) {
			if(can_move_left($elf, $grid)) 
				add_to_proposed($proposed, $elf[0]-1, $elf[1]);
			elseif(can_move_right($elf, $grid))
				add_to_proposed($proposed, $elf[0]+1, $elf[1]);
			elseif(can_move_up($elf, $grid))
				add_to_proposed($proposed, $elf[0], $elf[1]-1);
			elseif(can_move_down($elf, $grid))
				add_to_proposed($proposed, $elf[0], $elf[1]+1);
		} elseif($direction == 4) {
			if(can_move_right($elf, $grid))
				add_to_proposed($proposed, $elf[0]+1, $elf[1]);
			elseif(can_move_up($elf, $grid))
				add_to_proposed($proposed, $elf[0], $elf[1]-1);
			elseif(can_move_down($elf, $grid))
				add_to_proposed($proposed, $elf[0], $elf[1]+1);
			elseif(can_move_left($elf, $grid)) 
				add_to_proposed($proposed, $elf[0]-1, $elf[1]);
		}
	}

	if(count($proposed) == 0) {
		echo $round."\n";
		break;
	}

	$new_grid = array();
	foreach($grid as $elf) {
		if(is_elf_alone($elf, $grid)) {
			$new_grid[] = array($elf[0], $elf[1]);
		} elseif($direction == 1) {
			if(can_move_up($elf, $grid)) {
				if(can_move_up_2($elf, $proposed))
					$new_grid[] = array($elf[0], $elf[1]-1);
				else
					$new_grid[] = array($elf[0], $elf[1]);
			} elseif(can_move_down($elf, $grid)) {
				if(can_move_down_2($elf, $proposed))
					$new_grid[] = array($elf[0], $elf[1]+1);
				else
					$new_grid[] = array($elf[0], $elf[1]);
			} elseif(can_move_left($elf, $grid)) {
				if(can_move_left_2($elf, $proposed))
					$new_grid[] = array($elf[0]-1, $elf[1]);
				else
					$new_grid[] = array($elf[0], $elf[1]);
			} elseif(can_move_right($elf, $grid)) {
				if(can_move_right_2($elf, $proposed))
					$new_grid[] = array($elf[0]+1, $elf[1]);
				else
					$new_grid[] = array($elf[0], $elf[1]);
			} else {
				$new_grid[] = array($elf[0], $elf[1]);
			}
		} elseif($direction == 2) {
			if(can_move_down($elf, $grid)) {
				if(can_move_down_2($elf, $proposed))
					$new_grid[] = array($elf[0], $elf[1]+1);
				else
					$new_grid[] = array($elf[0], $elf[1]);
			} elseif(can_move_left($elf, $grid)) {
				if(can_move_left_2($elf, $proposed))
					$new_grid[] = array($elf[0]-1, $elf[1]);
				else
					$new_grid[] = array($elf[0], $elf[1]);
			} elseif(can_move_right($elf, $grid)) {
				if(can_move_right_2($elf, $proposed))
					$new_grid[] = array($elf[0]+1, $elf[1]);
				else
					$new_grid[] = array($elf[0], $elf[1]);
			} elseif(can_move_up($elf, $grid)) {
				if(can_move_up_2($elf, $proposed))
					$new_grid[] = array($elf[0], $elf[1]-1);
				else
					$new_grid[] = array($elf[0], $elf[1]);
			} else {
				$new_grid[] = array($elf[0], $elf[1]);
			}
		} elseif($direction == 3) {
			if(can_move_left($elf, $grid)) {
				if(can_move_left_2($elf, $proposed))
					$new_grid[] = array($elf[0]-1, $elf[1]);
				else
					$new_grid[] = array($elf[0], $elf[1]);
			} elseif(can_move_right($elf, $grid)) {
				if(can_move_right_2($elf, $proposed))
					$new_grid[] = array($elf[0]+1, $elf[1]);
				else
					$new_grid[] = array($elf[0], $elf[1]);
			} elseif(can_move_up($elf, $grid)) {
				if(can_move_up_2($elf, $proposed))
					$new_grid[] = array($elf[0], $elf[1]-1);
				else
					$new_grid[] = array($elf[0], $elf[1]);
			} elseif(can_move_down($elf, $grid)) {
				if(can_move_down_2($elf, $proposed))
					$new_grid[] = array($elf[0], $elf[1]+1);
				else
					$new_grid[] = array($elf[0], $elf[1]);
			} else {
				$new_grid[] = array($elf[0], $elf[1]);
			}
		} elseif($direction == 4) {
			if(can_move_right($elf, $grid)) {
				if(can_move_right_2($elf, $proposed))
					$new_grid[] = array($elf[0]+1, $elf[1]);
				else
					$new_grid[] = array($elf[0], $elf[1]);
			} elseif(can_move_up($elf, $grid)) {
				if(can_move_up_2($elf, $proposed))
					$new_grid[] = array($elf[0], $elf[1]-1);
				else
					$new_grid[] = array($elf[0], $elf[1]);
			} elseif(can_move_down($elf, $grid)) {
				if(can_move_down_2($elf, $proposed))
					$new_grid[] = array($elf[0], $elf[1]+1);
				else
					$new_grid[] = array($elf[0], $elf[1]);
			} elseif(can_move_left($elf, $grid)) {
				if(can_move_left_2($elf, $proposed))
					$new_grid[] = array($elf[0]-1, $elf[1]);
				else
					$new_grid[] = array($elf[0], $elf[1]);
			} else {
				$new_grid[] = array($elf[0], $elf[1]);
			}
		}
	}

	$grid = $new_grid;
	if($round == 10)
		echo area_covered($grid)."\n";

	$round++;
	$direction++;
	if($direction == 5)
		$direction = 1;
}

function area_covered ($grid) {
	$min_x = $min_y = PHP_INT_MAX;
	$max_x = $max_y = -PHP_INT_MAX;
	foreach($grid as $elf) {
		$min_x = min($min_x, $elf[0]);
		$min_y = min($min_y, $elf[1]);
		$max_x = max($max_x, $elf[0]);
		$max_y = max($max_y, $elf[1]);
	}
	return (($max_x-$min_x+1)*($max_y-$min_y+1))-count($grid);
}

function is_elf_alone($elf, $grid) {
	if(	!in_array(array($elf[0]-1, $elf[1]-1), $grid)
		&& !in_array(array($elf[0],   $elf[1]-1), $grid)
		&& !in_array(array($elf[0]+1, $elf[1]-1), $grid)
		&& !in_array(array($elf[0]-1, $elf[1]+1), $grid)
		&& !in_array(array($elf[0],   $elf[1]+1), $grid)
		&& !in_array(array($elf[0]+1, $elf[1]+1), $grid)
		&& !in_array(array($elf[0]-1, $elf[1]  ), $grid)
		&& !in_array(array($elf[0]+1, $elf[1]  ), $grid)
		)
		return 1;
	return 0;
}

function add_to_proposed(&$proposed, $x, $y) {
	if(isset($proposed[$x][$y]))
		$proposed[$x][$y]++;
	else
		$proposed[$x][$y] = 1;
}

function can_move_up($elf, $grid) {
	if(	!in_array(array($elf[0]-1, $elf[1]-1), $grid)
		&& !in_array(array($elf[0],   $elf[1]-1), $grid)
		&& !in_array(array($elf[0]+1, $elf[1]-1), $grid))
		return 1;
	return 0;
}

function can_move_down($elf, $grid) {
	if(	!in_array(array($elf[0]-1, $elf[1]+1), $grid)
		&& !in_array(array($elf[0],   $elf[1]+1), $grid)
		&& !in_array(array($elf[0]+1, $elf[1]+1), $grid))
		return 1;
	return 0;
}

function can_move_left($elf, $grid) {
	if(	!in_array(array($elf[0]-1, $elf[1]-1), $grid)
		&& !in_array(array($elf[0]-1, $elf[1]), $grid)
		&& !in_array(array($elf[0]-1, $elf[1]+1), $grid))
		return 1;
	return 0;
}

function can_move_right($elf, $grid) {
	if(	!in_array(array($elf[0]+1, $elf[1]-1), $grid)
		&& !in_array(array($elf[0]+1, $elf[1]), $grid)
		&& !in_array(array($elf[0]+1, $elf[1]+1), $grid))
		return 1;
	return 0;
}
function can_move_up_2($elf, $proposed) {
	if($proposed[$elf[0]][$elf[1]-1] <= 1)
		return 1;
	return 0;
}

function can_move_down_2($elf, $proposed) {
	if(($proposed[$elf[0]][$elf[1]+1] ?? 0) <= 1)
		return 1;
	return 0;
}

function can_move_left_2($elf, $proposed) {
	if(($proposed[$elf[0]-1][$elf[1]] ?? 0) <= 1)
		return 1;
	return 0;
}

function can_move_right_2($elf, $proposed) {
	if($proposed[$elf[0]+1][$elf[1]] <= 1)
		return 1;
	return 0;
}

?>