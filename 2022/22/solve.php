<?

$lines = file('input.txt', FILE_IGNORE_NEW_LINES);

foreach($lines as $line)
	if(strpos($line, '.') !== false || strpos($line, '#') !== false )
		$grid[] = str_split($line);
	elseif(strlen($line) > 0)
		$instructions = $line;

$max_y = count($grid) - 1;
$max_x = 0;
foreach($grid as $row)
	$max_x = max($max_x, count($row) - 1);

foreach($grid as $y => $row)
	if(count($row) < $max_x)
		$grid[$y] = array_merge($grid[$y], array_fill(count($row), $max_x - count($row) + 1, ' '));

// part 1
$pos_x = array_search('.', $grid[0]);
$pos_y = 0;
$orient = 0;
$ins = $instructions;

while(strlen($ins) > 0) {
	$num = sscanf($ins, "%d");
	if($num[0] != '') {
		$num = $num[0];
		$ins = substr($ins, strlen($num));
		if($orient == 0) {
			while($num > 0) {
				if($pos_x == $max_x || $grid[$pos_y][$pos_x + 1] == ' ') {
					$new_x = $pos_x + 1;
					if($new_x >= $max_x)
						$new_x = 0;
					while($grid[$pos_y][$new_x] == ' ') {
						$new_x++;
						if($new_x >= $max_x)
							$new_x = 0;
					}
					if($grid[$pos_y][$new_x] == '.')
						$pos_x = $new_x;
				} elseif($grid[$pos_y][$pos_x + 1] == '.') {
					$pos_x++;
				}
				$num--;
			}
		} elseif($orient == 1) {
			while($num > 0) {
				if($pos_y == $max_y || $grid[$pos_y + 1][$pos_x] == ' ') {
					$new_y = $pos_y + 1;
					if($new_y >= $max_y)
						$new_y = 0;
					while($grid[$new_y][$pos_x] == ' ') {
						$new_y++;
						if($new_y >= $max_y)
							$new_y = 0;
					}
					if($grid[$new_y][$pos_x] == '.')
						$pos_y = $new_y;
				} elseif($grid[$pos_y + 1][$pos_x] == '.') {
					$pos_y++;
				}
				$num--;
			}
		} elseif($orient == 2) {
			while($num > 0) {
				if($pos_x == 0 || $grid[$pos_y][$pos_x - 1] == ' ') {
					$new_x = $pos_x - 1;
					if($new_x <= 0)
						$new_x = $max_x;
					while($grid[$pos_y][$new_x] == ' ') {
						$new_x--;
						if($new_x <= 0)
							$new_x = $max_x;
					}
					if($grid[$pos_y][$new_x] == '.')
						$pos_x = $new_x;
				} elseif($grid[$pos_y][$pos_x - 1] == '.') {
					$pos_x--;
				}
				$num--;
			}
		} elseif($orient == 3) {
			while($num > 0) {
				if($pos_y == 0 || $grid[$pos_y - 1][$pos_x] == ' ') {
					$new_y = $pos_y - 1;
					if($new_y <= 0)
						$new_y = $max_y;
					while($grid[$new_y][$pos_x] == ' ') {
						$new_y--;
						if($new_y <= 0)
							$new_y = $max_y;
					}
					if($grid[$new_y][$pos_x] == '.')
						$pos_y = $new_y;
				} elseif($grid[$pos_y - 1][$pos_x] == '.') {
					$pos_y--;
				}
				$num--;
			}
		}
	} else {
		$turn = substr($ins, 0, 1);
		$ins = substr($ins, 1);
		if($turn == 'R')
			$orient++;
		elseif($turn == 'L')
			$orient--;
		if($orient == 4)
			$orient = 0;
		elseif($orient == -1)
			$orient = 3;
	}
}

echo (($pos_y + 1)*1000 + ($pos_x + 1) * 4 + $orient)."\n";

// part 2
$pos_x = array_search('.', $grid[0]);
$pos_y = 0;
$orient = 0;
$ins = $instructions;
while(strlen($ins) > 0) {
	$num = sscanf($ins, "%d");
	if($num[0] != '') {
		$num = $num[0];
		$ins = substr($ins, strlen($num));
		while($num > 0) {
			$old_x = $pos_x;
			$old_y = $pos_y;
			$old_orient = $orient;
			move_in_cube($pos_x, $pos_y, $orient);
			if($grid[$pos_y][$pos_x] == '#') {
				$pos_x = $old_x;
				$pos_y = $old_y;
				$orient = $old_orient;
				break;
			}
			$num--;
		}
	} else {
		$turn = substr($ins, 0, 1);
		$ins = substr($ins, 1);
		if($turn == 'R')
			$orient++;
		elseif($turn == 'L')
			$orient--;
		if($orient == 4)
			$orient = 0;
		elseif($orient == -1)
			$orient = 3;
	}
}

echo (($pos_y + 1)*1000 + ($pos_x + 1) * 4 + $orient)."\n";

function move_in_cube(&$x, &$y, &$orient) {
	if($orient == 0) {
		$x++;
		if($y >= 0 && $y <= 49) {
			if($x == 150) {
				$orient = 2;
				$y = 49 + 50 + 50 - $y;
				$x = 49 + 50;
			}
		} elseif ($y >= 50 && $y <= 49 + 50) {
			if($x == 100) {
				$orient = 3;
				$x = 50 + 49 + ($y - 49);
				$y = 49;
			}
		} elseif ($y >= 50 + 50 && $y <= 49 + 50 + 50) {
			if($x == 100) {
				$orient = 2;
				$y = (49 + 50 + 50 - $y);
				$x = 49 + 50 + 50;
			}
		} elseif ($y >= 50 + 50 + 50 && $y <= 49 + 50 + 50 + 50) {
			if($x == 50) {
				$orient = 3;
				$x = 49 + ($y - 49 - 50 - 50);
				$y = 49 + 50 + 50;
			}
		}
	} elseif($orient == 1) {
		$y++;
		if($x >= 0 && $x <= 49) {
			if($y == 200) {
				$y = 0;
				$x = $x + 100;
			}
		} elseif ($x >= 50 && $x <= 49 + 50) {
			if($y == 150) {
				$orient = 2;
				$y = 50 + 50 + 49 + ($x - 49);
				$x = 49;
			}
		} elseif ($x >= 50 + 50 && $x <= 49 + 50 + 50) {
			if($y == 50) {
				$orient = 2;
				$y = 49 + ($x - 49 - 50);
				$x = 49 + 50;
			}
		}
	} elseif($orient == 2) {
		$x--;
		if($y >= 0 && $y <= 49) {
			if($x == 49) {
				$orient = 0;
				$y = 49 + 50 + (50 - $y);
				$x = 0;
			}
		} elseif ($y >= 50 && $y <= 49 + 50) {
			if($x == 49) {
				$orient = 1;
				$x = $y - 50;
				$y = 100;
			}
		} elseif ($y >= 50 + 50 && $y <= 49 + 50 + 50) {
			if($x == -1) {
				$orient = 0;
				$y = (49 + 50 + 50 - $y);
				$x = 50;
			}
		} elseif ($y >= 50 + 50 + 50 && $y <= 49 + 50 + 50 + 50) {
			if($x == -1) {
				$orient = 1;
				$x = 49 + ($y - 49 - 50 - 50);
				$y = 0;
			}
		}
	} elseif($orient == 3) {
		$y--;
		if($x >= 0 && $x <= 49) {
			if($y == 99) {
				$orient = 0;
				$y = 50 + $x;
				$x = 50;
			}
		} elseif ($x >= 50 && $x <= 49 + 50) {
			if($y == -1) {
				$orient = 0;
				$y = 50 + 50 + 50 + ($x - 50);
				$x = 0;
			}
		} elseif ($x >= 50 + 50 && $x <= 49 + 50 + 50) {
			if($y == -1) {
				$y = 199;
				$x = $x - 50 - 50;
			}
		}
	}
}

?>