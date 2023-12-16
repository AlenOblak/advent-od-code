<?php

$lines = file('input.txt', FILE_IGNORE_NEW_LINES);

// part 1
$drawn_numbers = array();
$boards = array();
$board = array();

// read drawn numbers and boards
$drawn_numbers = explode(',', $lines[0]);
for($i = 2; $i < count($lines); $i++) {
	if($lines[$i] == '') {
		if(count($board) > 0) {
			$boards[] = $board;
			$board = array();
		}
	} else
		$board[] = preg_split('/\s+/', trim($lines[$i]));
}
$boards[] = $board;

// simulate the draw
foreach($drawn_numbers as $drawn_number) {
	// mark boards
	foreach($boards as $b => $board) {
		foreach($board as $i => $row) {
			foreach($row as $j => $col) {
				if($col == $drawn_number) {
					$boards[$b][$i][$j] = 'X';
				}
			}
		}
	}

	// check if win
	$wining_board = -1;
	foreach($boards as $b => $board) {
		for($i = 0; $i < 5; $i++) {
			$num1 = 0;
			$num2 = 0;
			for($j = 0; $j < 5; $j++) {
				if($board[$i][$j] == 'X')
					$num1++;
				if($board[$j][$i] == 'X')
					$num2++;
			}
			if($num1 == 5 || $num2 == 5)
				$wining_board = $b;
		}
	}
	
	if($wining_board > 0) {
		$num = 0;
		foreach($boards[$wining_board] as $row) {
			foreach($row as $col) {
				if($col != 'X') {
					$num += $col;
				}
			}
		}
		echo ($drawn_number * $num)."\n";
		break;
	}
}

// part 2
// simulate the draw
$wining_board = array();
foreach($boards as $b => $board) {
	$boards_won[$b] = 0;
}
$step = 1;
foreach($drawn_numbers as $drawn_number) {
	// mark boards
	foreach($boards as $b => $board) {
		foreach($board as $i => $row) {
			foreach($row as $j => $col) {
				if($col == $drawn_number) {
					$boards[$b][$i][$j] = 'X';
				}
			}
		}
	}

	// check if win
	foreach($boards as $b => $board) {
		for($i = 0; $i < 5; $i++) {
			$num1 = 0;
			$num2 = 0;
			for($j = 0; $j < 5; $j++) {
				if($board[$i][$j] == 'X')
					$num1++;
				if($board[$j][$i] == 'X')
					$num2++;
			}
			if($boards_won[$b] == 0 && ($num1 == 5 || $num2 == 5)) {
				$boards_won[$b] = $step;
				$num = 0;
				foreach($board as $row)
					foreach($row as $col)
						if($col != 'X')
							$num += $col;
				$last_score = ($drawn_number * $num);
			}
		}
	}
	$step++;
}

echo $last_score."\n";