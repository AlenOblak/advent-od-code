<?

$lines = file('input.txt', FILE_IGNORE_NEW_LINES);

// part 1
$room[11] = substr($lines[2], 3, 1);
$room[21] = substr($lines[2], 5, 1);
$room[31] = substr($lines[2], 7, 1);
$room[41] = substr($lines[2], 9, 1);
$room[12] = substr($lines[3], 3, 1);
$room[22] = substr($lines[3], 5, 1);
$room[32] = substr($lines[3], 7, 1);
$room[42] = substr($lines[3], 9, 1);
$room[1] = '.';
$room[2] = '.';
$room[3] = '.';
$room[4] = '.';
$room[5] = '.';
$room[6] = '.';
$room[7] = '.';
$room[0] = 0;

$states[] = $room;
$visited = array();
$best_score = 999999999;
while(count($states) > 0) {
	$state = array_pop($states);
	// check for solution
	if($state[11] == 'A' && $state[12] == 'A' && $state[21] == 'B' && $state[22] == 'B' && $state[31] == 'C' && $state[32] == 'C' && $state[41] == 'D' && $state[42] == 'D' ) {
		if($state[0] < $best_score)
			$best_score = $state[0];
	}
	// check if state known
	$key = state_to_key($state);
	if(array_key_exists($key, $visited)) {
		if($visited[$key] <= $state[0])
			continue;
		else
			$visited[$key] = $state[0];
	} else {
		$visited[$key] = $state[0];
	}
	if($state[0] < $best_score) {
		$new_states = new_states($state);
		foreach($new_states as $new)
			if($new[0] < $best_score)
				$states[] = $new;
	}
}

echo 'best score '.$best_score."\n";

// part 2
$room[14] = $room[12];
$room[24] = $room[22];
$room[34] = $room[32];
$room[44] = $room[42];
$room[12] = 'D';
$room[22] = 'C';
$room[32] = 'B';
$room[42] = 'A';
$room[13] = 'D';
$room[23] = 'B';
$room[33] = 'A';
$room[43] = 'C';

$states = array();
$states[] = $room;
$visited = array();
$best_score = 999999999;
while(count($states) > 0) {
	$state = array_pop($states);
	// check for solution
	if($state[11] == 'A' && $state[12] == 'A' && $state[13] == 'A' && $state[14] == 'A' &&
		$state[21] == 'B' && $state[22] == 'B' && $state[23] == 'B' && $state[24] == 'B' &&
		$state[31] == 'C' && $state[32] == 'C' && $state[33] == 'C' && $state[34] == 'C' &&
		$state[41] == 'D' && $state[42] == 'D' && $state[43] == 'D' && $state[44] == 'D') {
		if($state[0] < $best_score)
			$best_score = $state[0];
	}
	// check if state known
	$key = state_to_key_2($state);
	if(array_key_exists($key, $visited)) {
		if($visited[$key] <= $state[0])
			continue;
		else
			$visited[$key] = $state[0];
	} else {
		$visited[$key] = $state[0];
	}
	if($state[0] < $best_score) {
		$new_states = new_states_2($state);
		foreach($new_states as $new)
			if($new[0] < $best_score)
				$states[] = $new;
	}
}

echo 'best score '.$best_score."\n";

function new_states($state) {
	$new_states = array();
	// room 1 up position
	if($state[11] != 'A' || $state[12] != 'A') {
		if($state[1] == '.' && $state[2] == '.' && $state[11] != '.') {
			$new_state = $state;
			$new_state[1] = $state[11];
			$new_state[11] = '.';
			$new_state[0] += price($state[11], 3);
			$new_states[] = $new_state;
		}
		if($state[2] == '.' && $state[11] != '.') {
			$new_state = $state;
			$new_state[2] = $state[11];
			$new_state[11] = '.';
			$new_state[0] += price($state[11], 2);
			$new_states[] = $new_state;
		}
		if($state[3] == '.' && $state[11] != '.') {
			$new_state = $state;
			$new_state[3] = $state[11];
			$new_state[11] = '.';
			$new_state[0] += price($state[11], 2);
			$new_states[] = $new_state;
		}
		if($state[3] == '.' && $state[4] == '.' && $state[11] != '.') {
			$new_state = $state;
			$new_state[4] = $state[11];
			$new_state[11] = '.';
			$new_state[0] += price($state[11], 4);
			$new_states[] = $new_state;
		}
		if($state[3] == '.' && $state[4] == '.' && $state[5] == '.' && $state[11] != '.') {
			$new_state = $state;
			$new_state[5] = $state[11];
			$new_state[11] = '.';
			$new_state[0] += price($state[11], 6);
			$new_states[] = $new_state;
		}
		if($state[3] == '.' && $state[4] == '.' && $state[5] == '.' && $state[6] == '.' && $state[11] != '.') {
			$new_state = $state;
			$new_state[6] = $state[11];
			$new_state[11] = '.';
			$new_state[0] += price($state[11], 8);
			$new_states[] = $new_state;
		}
		if($state[3] == '.' && $state[4] == '.' && $state[5] == '.' && $state[6] == '.' && $state[7] == '.' && $state[11] != '.') {
			$new_state = $state;
			$new_state[7] = $state[11];
			$new_state[11] = '.';
			$new_state[0] += price($state[11], 9);
			$new_states[] = $new_state;
		}
	}
	// room 2 up position
	if($state[21] != 'B' || $state[22] != 'B') {
		if($state[1] == '.' && $state[2] == '.' && $state[3] == '.' && $state[21] != '.') {
			$new_state = $state;
			$new_state[1] = $state[21];
			$new_state[21] = '.';
			$new_state[0] += price($state[21], 5);
			$new_states[] = $new_state;
		}
		if($state[2] == '.' && $state[3] == '.' && $state[21] != '.') {
			$new_state = $state;
			$new_state[2] = $state[21];
			$new_state[21] = '.';
			$new_state[0] += price($state[21], 4);
			$new_states[] = $new_state;
		}
		if($state[3] == '.' && $state[21] != '.') {
			$new_state = $state;
			$new_state[3] = $state[21];
			$new_state[21] = '.';
			$new_state[0] += price($state[21], 2);
			$new_states[] = $new_state;
		}
		if($state[4] == '.' && $state[21] != '.') {
			$new_state = $state;
			$new_state[4] = $state[21];
			$new_state[21] = '.';
			$new_state[0] += price($state[21], 2);
			$new_states[] = $new_state;
		}
		if($state[4] == '.' && $state[5] == '.' && $state[21] != '.') {
			$new_state = $state;
			$new_state[5] = $state[21];
			$new_state[21] = '.';
			$new_state[0] += price($state[21], 4);
			$new_states[] = $new_state;
		}
		if($state[4] == '.' && $state[5] == '.' && $state[6] == '.' && $state[21] != '.') {
			$new_state = $state;
			$new_state[6] = $state[21];
			$new_state[21] = '.';
			$new_state[0] += price($state[21], 6);
			$new_states[] = $new_state;
		}
		if($state[4] == '.' && $state[5] == '.' && $state[6] == '.' && $state[7] == '.' && $state[21] != '.') {
			$new_state = $state;
			$new_state[7] = $state[21];
			$new_state[21] = '.';
			$new_state[0] += price($state[21], 7);
			$new_states[] = $new_state;
		}
	}
	// room 3 up position
	if($state[31] != 'C' || $state[32] != 'C') {
		if($state[1] == '.' && $state[2] == '.' && $state[3] == '.' && $state[4] == '.' && $state[31] != '.') {
			$new_state = $state;
			$new_state[1] = $state[31];
			$new_state[31] = '.';
			$new_state[0] += price($state[31], 7);
			$new_states[] = $new_state;
		}
		if($state[2] == '.' && $state[3] == '.' && $state[4] == '.' && $state[31] != '.') {
			$new_state = $state;
			$new_state[2] = $state[31];
			$new_state[31] = '.';
			$new_state[0] += price($state[31], 6);
			$new_states[] = $new_state;
		}
		if($state[3] == '.' && $state[4] == '.' && $state[31] != '.') {
			$new_state = $state;
			$new_state[3] = $state[31];
			$new_state[31] = '.';
			$new_state[0] += price($state[31], 4);
			$new_states[] = $new_state;
		}
		if($state[4] == '.' && $state[31] != '.') {
			$new_state = $state;
			$new_state[4] = $state[31];
			$new_state[31] = '.';
			$new_state[0] += price($state[31], 2);
			$new_states[] = $new_state;
		}
		if($state[5] == '.' && $state[31] != '.') {
			$new_state = $state;
			$new_state[5] = $state[31];
			$new_state[31] = '.';
			$new_state[0] += price($state[31], 2);
			$new_states[] = $new_state;
		}
		if($state[5] == '.' && $state[6] == '.' && $state[31] != '.') {
			$new_state = $state;
			$new_state[6] = $state[31];
			$new_state[31] = '.';
			$new_state[0] += price($state[31], 4);
			$new_states[] = $new_state;
		}
		if($state[5] == '.' && $state[6] == '.' && $state[7] == '.' && $state[31] != '.') {
			$new_state = $state;
			$new_state[7] = $state[31];
			$new_state[31] = '.';
			$new_state[0] += price($state[31], 5);
			$new_states[] = $new_state;
		}
	}
	// room 4 up position
	if($state[41] != 'D' || $state[42] != 'D') {
		if($state[1] == '.' && $state[2] == '.' && $state[3] == '.' && $state[4] == '.' && $state[5] == '.' && $state[41] != '.') {
			$new_state = $state;
			$new_state[1] = $state[41];
			$new_state[41] = '.';
			$new_state[0] += price($state[41], 9);
			$new_states[] = $new_state;
		}
		if($state[2] == '.' && $state[3] == '.' && $state[4] == '.' && $state[5] == '.' && $state[41] != '.') {
			$new_state = $state;
			$new_state[2] = $state[41];
			$new_state[41] = '.';
			$new_state[0] += price($state[41], 8);
			$new_states[] = $new_state;
		}
		if($state[3] == '.' && $state[4] == '.' && $state[5] == '.' && $state[41] != '.') {
			$new_state = $state;
			$new_state[3] = $state[41];
			$new_state[41] = '.';
			$new_state[0] += price($state[41], 6);
			$new_states[] = $new_state;
		}
		if($state[4] == '.' && $state[5] == '.' && $state[41] != '.') {
			$new_state = $state;
			$new_state[4] = $state[41];
			$new_state[41] = '.';
			$new_state[0] += price($state[41], 4);
			$new_states[] = $new_state;
		}
		if($state[5] == '.' && $state[41] != '.') {
			$new_state = $state;
			$new_state[5] = $state[41];
			$new_state[41] = '.';
			$new_state[0] += price($state[41], 2);
			$new_states[] = $new_state;
		}
		if($state[6] == '.' && $state[41] != '.') {
			$new_state = $state;
			$new_state[6] = $state[41];
			$new_state[41] = '.';
			$new_state[0] += price($state[41], 2);
			$new_states[] = $new_state;
		}
		if($state[6] == '.' && $state[7] == '.' && $state[41] != '.') {
			$new_state = $state;
			$new_state[7] = $state[41];
			$new_state[41] = '.';
			$new_state[0] += price($state[41], 3);
			$new_states[] = $new_state;
		}
	}
	// room 1 down position
	if($state[12] != 'A') {
		if($state[1] == '.' && $state[2] == '.' && $state[11] == '.' && $state[12] != '.') {
			$new_state = $state;
			$new_state[1] = $state[12];
			$new_state[12] = '.';
			$new_state[0] += price($state[12], 4);
			$new_states[] = $new_state;
		}
		if($state[2] == '.' && $state[11] == '.' && $state[12] != '.') {
			$new_state = $state;
			$new_state[2] = $state[12];
			$new_state[12] = '.';
			$new_state[0] += price($state[12], 3);
			$new_states[] = $new_state;
		}
		if($state[3] == '.' && $state[11] == '.' && $state[12] != '.') {
			$new_state = $state;
			$new_state[3] = $state[12];
			$new_state[12] = '.';
			$new_state[0] += price($state[12], 3);
			$new_states[] = $new_state;
		}
		if($state[3] == '.' && $state[4] == '.' && $state[11] == '.' && $state[12] != '.') {
			$new_state = $state;
			$new_state[4] = $state[12];
			$new_state[12] = '.';
			$new_state[0] += price($state[12], 5);
			$new_states[] = $new_state;
		}
		if($state[3] == '.' && $state[4] == '.' && $state[5] == '.' && $state[11] == '.' && $state[12] != '.') {
			$new_state = $state;
			$new_state[5] = $state[12];
			$new_state[12] = '.';
			$new_state[0] += price($state[12], 7);
			$new_states[] = $new_state;
		}
		if($state[3] == '.' && $state[4] == '.' && $state[5] == '.' && $state[6] == '.' && $state[11] == '.' && $state[12] != '.') {
			$new_state = $state;
			$new_state[6] = $state[12];
			$new_state[12] = '.';
			$new_state[0] += price($state[12], 9);
			$new_states[] = $new_state;
		}
		if($state[3] == '.' && $state[4] == '.' && $state[5] == '.' && $state[6] == '.' && $state[7] == '.' && $state[11] == '.' && $state[12] != '.') {
			$new_state = $state;
			$new_state[7] = $state[12];
			$new_state[12] = '.';
			$new_state[0] += price($state[12], 10);
			$new_states[] = $new_state;
		}
	}
	// room 2 down position
	if($state[22] != 'B') {
		if($state[1] == '.' && $state[2] == '.' && $state[3] == '.' && $state[21] == '.' && $state[22] != '.') {
			$new_state = $state;
			$new_state[1] = $state[22];
			$new_state[22] = '.';
			$new_state[0] += price($state[22], 6);
			$new_states[] = $new_state;
		}
		if($state[2] == '.' && $state[3] == '.' && $state[21] == '.' && $state[22] != '.') {
			$new_state = $state;
			$new_state[2] = $state[22];
			$new_state[22] = '.';
			$new_state[0] += price($state[22], 5);
			$new_states[] = $new_state;
		}
		if($state[3] == '.' && $state[21] == '.' && $state[22] != '.') {
			$new_state = $state;
			$new_state[3] = $state[22];
			$new_state[22] = '.';
			$new_state[0] += price($state[22], 3);
			$new_states[] = $new_state;
		}
		if($state[4] == '.' && $state[21] == '.' && $state[22] != '.') {
			$new_state = $state;
			$new_state[4] = $state[22];
			$new_state[22] = '.';
			$new_state[0] += price($state[22], 3);
			$new_states[] = $new_state;
		}
		if($state[4] == '.' && $state[5] == '.' && $state[21] == '.' && $state[22] != '.') {
			$new_state = $state;
			$new_state[5] = $state[22];
			$new_state[22] = '.';
			$new_state[0] += price($state[22], 5);
			$new_states[] = $new_state;
		}
		if($state[4] == '.' && $state[5] == '.' && $state[6] == '.' && $state[21] == '.' && $state[22] != '.') {
			$new_state = $state;
			$new_state[6] = $state[22];
			$new_state[22] = '.';
			$new_state[0] += price($state[22], 7);
			$new_states[] = $new_state;
		}
		if($state[4] == '.' && $state[5] == '.' && $state[6] == '.' && $state[7] == '.' && $state[21] == '.' && $state[22] != '.') {
			$new_state = $state;
			$new_state[7] = $state[22];
			$new_state[22] = '.';
			$new_state[0] += price($state[22], 8);
			$new_states[] = $new_state;
		}
	}
	// room 3 down position
	if($state[32] != 'C') {
		if($state[1] == '.' && $state[2] == '.' && $state[3] == '.' && $state[4] == '.' && $state[31] == '.' && $state[32] != '.') {
			$new_state = $state;
			$new_state[1] = $state[32];
			$new_state[32] = '.';
			$new_state[0] += price($state[32], 8);
			$new_states[] = $new_state;
		}
		if($state[2] == '.' && $state[3] == '.' && $state[4] == '.' && $state[31] == '.' && $state[32] != '.') {
			$new_state = $state;
			$new_state[2] = $state[32];
			$new_state[32] = '.';
			$new_state[0] += price($state[32], 7);
			$new_states[] = $new_state;
		}
		if($state[3] == '.' && $state[4] == '.' && $state[31] == '.' && $state[32] != '.') {
			$new_state = $state;
			$new_state[3] = $state[32];
			$new_state[32] = '.';
			$new_state[0] += price($state[32], 5);
			$new_states[] = $new_state;
		}
		if($state[4] == '.' && $state[31] == '.' && $state[32] != '.') {
			$new_state = $state;
			$new_state[4] = $state[32];
			$new_state[32] = '.';
			$new_state[0] += price($state[32], 3);
			$new_states[] = $new_state;
		}
		if($state[5] == '.' && $state[31] == '.' && $state[32] != '.') {
			$new_state = $state;
			$new_state[5] = $state[32];
			$new_state[32] = '.';
			$new_state[0] += price($state[32], 3);
			$new_states[] = $new_state;
		}
		if($state[5] == '.' && $state[6] == '.' && $state[31] == '.' && $state[32] != '.') {
			$new_state = $state;
			$new_state[6] = $state[32];
			$new_state[32] = '.';
			$new_state[0] += price($state[32], 5);
			$new_states[] = $new_state;
		}
		if($state[5] == '.' && $state[6] == '.' && $state[7] == '.' && $state[31] == '.' && $state[32] != '.') {
			$new_state = $state;
			$new_state[7] = $state[32];
			$new_state[32] = '.';
			$new_state[0] += price($state[32], 6);
			$new_states[] = $new_state;
		}
	}
	// room 4 down position
	if($state[42] != 'D') {
		if($state[1] == '.' && $state[2] == '.' && $state[3] == '.' && $state[4] == '.' && $state[5] == '.' && $state[41] == '.' && $state[42] != '.') {
			$new_state = $state;
			$new_state[1] = $state[42];
			$new_state[42] = '.';
			$new_state[0] += price($state[42], 10);
			$new_states[] = $new_state;
		}
		if($state[2] == '.' && $state[3] == '.' && $state[4] == '.' && $state[5] == '.' && $state[41] == '.' && $state[42] != '.') {
			$new_state = $state;
			$new_state[2] = $state[42];
			$new_state[42] = '.';
			$new_state[0] += price($state[42], 9);
			$new_states[] = $new_state;
		}
		if($state[3] == '.' && $state[4] == '.' && $state[5] == '.' && $state[41] == '.' && $state[42] != '.') {
			$new_state = $state;
			$new_state[3] = $state[42];
			$new_state[42] = '.';
			$new_state[0] += price($state[42], 7);
			$new_states[] = $new_state;
		}
		if($state[4] == '.' && $state[5] == '.' && $state[41] == '.' && $state[42] != '.') {
			$new_state = $state;
			$new_state[4] = $state[42];
			$new_state[42] = '.';
			$new_state[0] += price($state[42], 5);
			$new_states[] = $new_state;
		}
		if($state[5] == '.' && $state[41] == '.' && $state[42] != '.') {
			$new_state = $state;
			$new_state[5] = $state[42];
			$new_state[42] = '.';
			$new_state[0] += price($state[42], 3);
			$new_states[] = $new_state;
		}
		if($state[6] == '.' && $state[41] == '.' && $state[42] != '.') {
			$new_state = $state;
			$new_state[6] = $state[42];
			$new_state[42] = '.';
			$new_state[0] += price($state[42], 3);
			$new_states[] = $new_state;
		}
		if($state[6] == '.' && $state[7] == '.' && $state[41] == '.' && $state[42] != '.') {
			$new_state = $state;
			$new_state[7] = $state[42];
			$new_state[42] = '.';
			$new_state[0] += price($state[42], 4);
			$new_states[] = $new_state;
		}
	}
	// hallway position 1
	if($state[1] != '.' && $state[2] == '.') {
		// A down
		if($state[1] == 'A' && $state[11] == '.' && $state[12] == '.') {
			$new_state = $state;
			$new_state[12] = $new_state[1];
			$new_state[1] = '.';
			$new_state[0] += price($state[1], 4);
			$new_states[] = $new_state;
		}
		// A up
		if($state[1] == 'A' && $state[11] == '.' && $state[12] == 'A') {
			$new_state = $state;
			$new_state[11] = $new_state[1];
			$new_state[1] = '.';
			$new_state[0] += price($state[1], 3);
			$new_states[] = $new_state;
		}
		// B down
		if($state[1] == 'B' && $state[3] == '.' && $state[21] == '.' && $state[22] == '.') {
			$new_state = $state;
			$new_state[22] = $new_state[1];
			$new_state[1] = '.';
			$new_state[0] += price($state[1], 6);
			$new_states[] = $new_state;
		}
		// B up
		if($state[1] == 'B' && $state[3] == '.' && $state[21] == '.' && $state[22] == 'B') {
			$new_state = $state;
			$new_state[21] = $new_state[1];
			$new_state[1] = '.';
			$new_state[0] += price($state[1], 5);
			$new_states[] = $new_state;
		}
		// C down
		if($state[1] == 'C' && $state[3] == '.' && $state[4] == '.' && $state[31] == '.' && $state[32] == '.') {
			$new_state = $state;
			$new_state[32] = $new_state[1];
			$new_state[1] = '.';
			$new_state[0] += price($state[1], 8);
			$new_states[] = $new_state;
		}
		// C up
		if($state[1] == 'C' && $state[3] == '.' && $state[4] == '.' && $state[31] == '.' && $state[32] == 'C') {
			$new_state = $state;
			$new_state[31] = $new_state[1];
			$new_state[1] = '.';
			$new_state[0] += price($state[1], 7);
			$new_states[] = $new_state;
		}
		// D down
		if($state[1] == 'D' && $state[3] == '.' && $state[4] == '.' && $state[5] == '.' && $state[41] == '.' && $state[42] == '.') {
			$new_state = $state;
			$new_state[42] = $new_state[1];
			$new_state[1] = '.';
			$new_state[0] += price($state[1], 10);
			$new_states[] = $new_state;
		}
		// D up
		if($state[1] == 'D' && $state[3] == '.' && $state[4] == '.' && $state[5] == '.' && $state[41] == '.' && $state[42] == 'D') {
			$new_state = $state;
			$new_state[41] = $new_state[1];
			$new_state[1] = '.';
			$new_state[0] += price($state[1], 9);
			$new_states[] = $new_state;
		}
	}
	// hallway position 2
	if($state[2] != '.') {
		// A down
		if($state[2] == 'A' && $state[11] == '.' && $state[12] == '.') {
			$new_state = $state;
			$new_state[12] = $new_state[2];
			$new_state[2] = '.';
			$new_state[0] += price($state[2], 3);
			$new_states[] = $new_state;
		}
		// A up
		if($state[2] == 'A' && $state[11] == '.' && $state[12] == 'A') {
			$new_state = $state;
			$new_state[11] = $new_state[2];
			$new_state[2] = '.';
			$new_state[0] += price($state[2], 2);
			$new_states[] = $new_state;
		}
		// B down
		if($state[2] == 'B' && $state[3] == '.' && $state[21] == '.' && $state[22] == '.') {
			$new_state = $state;
			$new_state[22] = $new_state[2];
			$new_state[2] = '.';
			$new_state[0] += price($state[2], 5);
			$new_states[] = $new_state;
		}
		// B up
		if($state[2] == 'B' && $state[3] == '.' && $state[21] == '.' && $state[22] == 'B') {
			$new_state = $state;
			$new_state[21] = $new_state[2];
			$new_state[2] = '.';
			$new_state[0] += price($state[2], 4);
			$new_states[] = $new_state;
		}
		// C down
		if($state[2] == 'C' && $state[3] == '.' && $state[4] == '.' && $state[31] == '.' && $state[32] == '.') {
			$new_state = $state;
			$new_state[32] = $new_state[2];
			$new_state[2] = '.';
			$new_state[0] += price($state[2], 7);
			$new_states[] = $new_state;
		}
		// C up
		if($state[2] == 'C' && $state[3] == '.' && $state[4] == '.' && $state[31] == '.' && $state[32] == 'C') {
			$new_state = $state;
			$new_state[31] = $new_state[2];
			$new_state[2] = '.';
			$new_state[0] += price($state[2], 6);
			$new_states[] = $new_state;
		}
		// D down
		if($state[2] == 'D' && $state[3] == '.' && $state[4] == '.' && $state[5] == '.' && $state[41] == '.' && $state[42] == '.') {
			$new_state = $state;
			$new_state[42] = $new_state[2];
			$new_state[2] = '.';
			$new_state[0] += price($state[2], 9);
			$new_states[] = $new_state;
		}
		// D up
		if($state[2] == 'D' && $state[3] == '.' && $state[4] == '.' && $state[5] == '.' && $state[41] == '.' && $state[42] == 'D') {
			$new_state = $state;
			$new_state[41] = $new_state[2];
			$new_state[2] = '.';
			$new_state[0] += price($state[2], 8);
			$new_states[] = $new_state;
		}
	}
	// hallway position 3
	if($state[3] != '.') {
		// A down
		if($state[3] == 'A' && $state[11] == '.' && $state[12] == '.') {
			$new_state = $state;
			$new_state[12] = $new_state[3];
			$new_state[3] = '.';
			$new_state[0] += price($state[3], 3);
			$new_states[] = $new_state;
		}
		// A up
		if($state[3] == 'A' && $state[11] == '.' && $state[12] == 'A') {
			$new_state = $state;
			$new_state[11] = $new_state[3];
			$new_state[3] = '.';
			$new_state[0] += price($state[3], 2);
			$new_states[] = $new_state;
		}
		// B down
		if($state[3] == 'B' && $state[21] == '.' && $state[22] == '.') {
			$new_state = $state;
			$new_state[22] = $new_state[3];
			$new_state[3] = '.';
			$new_state[0] += price($state[3], 3);
			$new_states[] = $new_state;
		}
		// B up
		if($state[3] == 'B' && $state[21] == '.' && $state[22] == 'B') {
			$new_state = $state;
			$new_state[21] = $new_state[3];
			$new_state[3] = '.';
			$new_state[0] += price($state[3], 2);
			$new_states[] = $new_state;
		}
		// C down
		if($state[3] == 'C' && $state[4] == '.' && $state[31] == '.' && $state[32] == '.') {
			$new_state = $state;
			$new_state[32] = $new_state[3];
			$new_state[3] = '.';
			$new_state[0] += price($state[3], 5);
			$new_states[] = $new_state;
		}
		// C up
		if($state[3] == 'C' && $state[4] == '.' && $state[31] == '.' && $state[32] == 'C') {
			$new_state = $state;
			$new_state[31] = $new_state[3];
			$new_state[3] = '.';
			$new_state[0] += price($state[3], 4);
			$new_states[] = $new_state;
		}
		// D down
		if($state[3] == 'D' && $state[4] == '.' && $state[5] == '.' && $state[41] == '.' && $state[42] == '.') {
			$new_state = $state;
			$new_state[42] = $new_state[3];
			$new_state[3] = '.';
			$new_state[0] += price($state[3], 7);
			$new_states[] = $new_state;
		}
		// D up
		if($state[3] == 'D' && $state[4] == '.' && $state[5] == '.' && $state[41] == '.' && $state[42] == 'D') {
			$new_state = $state;
			$new_state[41] = $new_state[3];
			$new_state[3] = '.';
			$new_state[0] += price($state[3], 6);
			$new_states[] = $new_state;
		}
	}
	// hallway position 4
	if($state[4] != '.') {
		// A down
		if($state[4] == 'A' && $state[3] == '.' && $state[11] == '.' && $state[12] == '.') {
			$new_state = $state;
			$new_state[12] = $new_state[4];
			$new_state[4] = '.';
			$new_state[0] += price($state[4], 5);
			$new_states[] = $new_state;
		}
		// A up
		if($state[4] == 'A' && $state[3] == '.' && $state[11] == '.' && $state[12] == 'A') {
			$new_state = $state;
			$new_state[11] = $new_state[4];
			$new_state[4] = '.';
			$new_state[0] += price($state[4], 4);
			$new_states[] = $new_state;
		}
		// B down
		if($state[4] == 'B' && $state[21] == '.' && $state[22] == '.') {
			$new_state = $state;
			$new_state[22] = $new_state[4];
			$new_state[4] = '.';
			$new_state[0] += price($state[4], 3);
			$new_states[] = $new_state;
		}
		// B up
		if($state[4] == 'B' && $state[21] == '.' && $state[22] == 'B') {
			$new_state = $state;
			$new_state[21] = $new_state[4];
			$new_state[4] = '.';
			$new_state[0] += price($state[4], 2);
			$new_states[] = $new_state;
		}
		// C down
		if($state[4] == 'C' && $state[31] == '.' && $state[32] == '.') {
			$new_state = $state;
			$new_state[32] = $new_state[4];
			$new_state[4] = '.';
			$new_state[0] += price($state[4], 3);
			$new_states[] = $new_state;
		}
		// C up
		if($state[4] == 'C' && $state[31] == '.' && $state[32] == 'C') {
			$new_state = $state;
			$new_state[31] = $new_state[4];
			$new_state[4] = '.';
			$new_state[0] += price($state[4], 2);
			$new_states[] = $new_state;
		}
		// D down
		if($state[4] == 'D' && $state[5] == '.' && $state[41] == '.' && $state[42] == '.') {
			$new_state = $state;
			$new_state[42] = $new_state[4];
			$new_state[4] = '.';
			$new_state[0] += price($state[4], 5);
			$new_states[] = $new_state;
		}
		// D up
		if($state[4] == 'D' && $state[5] == '.' && $state[41] == '.' && $state[42] == 'D') {
			$new_state = $state;
			$new_state[41] = $new_state[4];
			$new_state[4] = '.';
			$new_state[0] += price($state[4], 4);
			$new_states[] = $new_state;
		}
	}
	// hallway position 5
	if($state[5] != '.') {
		// A down
		if($state[5] == 'A' && $state[3] == '.' && $state[4] == '.' && $state[11] == '.' && $state[12] == '.') {
			$new_state = $state;
			$new_state[12] = $new_state[5];
			$new_state[5] = '.';
			$new_state[0] += price($state[5], 7);
			$new_states[] = $new_state;
		}
		// A up
		if($state[5] == 'A' && $state[3] == '.' && $state[4] == '.' && $state[11] == '.' && $state[12] == 'A') {
			$new_state = $state;
			$new_state[11] = $new_state[5];
			$new_state[5] = '.';
			$new_state[0] += price($state[5], 6);
			$new_states[] = $new_state;
		}
		// B down
		if($state[5] == 'B' && $state[4] == '.' && $state[21] == '.' && $state[22] == '.') {
			$new_state = $state;
			$new_state[22] = $new_state[5];
			$new_state[5] = '.';
			$new_state[0] += price($state[5], 5);
			$new_states[] = $new_state;
		}
		// B up
		if($state[5] == 'B' && $state[4] == '.' && $state[21] == '.' && $state[22] == 'B') {
			$new_state = $state;
			$new_state[21] = $new_state[5];
			$new_state[5] = '.';
			$new_state[0] += price($state[5], 4);
			$new_states[] = $new_state;
		}
		// C down
		if($state[5] == 'C' && $state[31] == '.' && $state[32] == '.') {
			$new_state = $state;
			$new_state[32] = $new_state[5];
			$new_state[5] = '.';
			$new_state[0] += price($state[5], 3);
			$new_states[] = $new_state;
		}
		// C up
		if($state[5] == 'C' && $state[31] == '.' && $state[32] == 'C') {
			$new_state = $state;
			$new_state[31] = $new_state[5];
			$new_state[5] = '.';
			$new_state[0] += price($state[5], 2);
			$new_states[] = $new_state;
		}
		// D down
		if($state[5] == 'D' && $state[41] == '.' && $state[42] == '.') {
			$new_state = $state;
			$new_state[42] = $new_state[5];
			$new_state[5] = '.';
			$new_state[0] += price($state[5], 3);
			$new_states[] = $new_state;
		}
		// D up
		if($state[5] == 'D' && $state[41] == '.' && $state[42] == 'D') {
			$new_state = $state;
			$new_state[41] = $new_state[5];
			$new_state[5] = '.';
			$new_state[0] += price($state[5], 2);
			$new_states[] = $new_state;
		}
	}
	// hallway position 6
	if($state[6] != '.') {
		// A down
		if($state[6] == 'A' && $state[3] == '.' && $state[4] == '.' && $state[5] == '.' && $state[11] == '.' && $state[12] == '.') {
			$new_state = $state;
			$new_state[12] = $new_state[6];
			$new_state[6] = '.';
			$new_state[0] += price($state[6], 9);
			$new_states[] = $new_state;
		}
		// A up
		if($state[6] == 'A' && $state[3] == '.' && $state[4] == '.' && $state[5] == '.' && $state[11] == '.' && $state[12] == 'A') {
			$new_state = $state;
			$new_state[11] = $new_state[6];
			$new_state[6] = '.';
			$new_state[0] += price($state[6], 8);
			$new_states[] = $new_state;
		}
		// B down
		if($state[6] == 'B' && $state[4] == '.' && $state[5] == '.' && $state[21] == '.' && $state[22] == '.') {
			$new_state = $state;
			$new_state[22] = $new_state[6];
			$new_state[6] = '.';
			$new_state[0] += price($state[6], 7);
			$new_states[] = $new_state;
		}
		// B up
		if($state[6] == 'B' && $state[4] == '.' && $state[5] == '.' && $state[21] == '.' && $state[22] == 'B') {
			$new_state = $state;
			$new_state[21] = $new_state[6];
			$new_state[6] = '.';
			$new_state[0] += price($state[6], 6);
			$new_states[] = $new_state;
		}
		// C down
		if($state[6] == 'C' && $state[5] == '.' && $state[31] == '.' && $state[32] == '.') {
			$new_state = $state;
			$new_state[32] = $new_state[6];
			$new_state[6] = '.';
			$new_state[0] += price($state[6], 5);
			$new_states[] = $new_state;
		}
		// C up
		if($state[6] == 'C' && $state[5] == '.' && $state[31] == '.' && $state[32] == 'C') {
			$new_state = $state;
			$new_state[31] = $new_state[6];
			$new_state[6] = '.';
			$new_state[0] += price($state[6], 4);
			$new_states[] = $new_state;
		}
		// D down
		if($state[6] == 'D' && $state[41] == '.' && $state[42] == '.') {
			$new_state = $state;
			$new_state[42] = $new_state[6];
			$new_state[6] = '.';
			$new_state[0] += price($state[6], 3);
			$new_states[] = $new_state;
		}
		// D up
		if($state[6] == 'D' && $state[41] == '.' && $state[42] == 'D') {
			$new_state = $state;
			$new_state[41] = $new_state[6];
			$new_state[6] = '.';
			$new_state[0] += price($state[6], 2);
			$new_states[] = $new_state;
		}
	}
	// hallway position 7
	if($state[7] != '.' && $state[6] == '.') {
		// A down
		if($state[7] == 'A' && $state[3] == '.' && $state[4] == '.' && $state[5] == '.' && $state[11] == '.' && $state[12] == '.') {
			$new_state = $state;
			$new_state[12] = $new_state[7];
			$new_state[7] = '.';
			$new_state[0] += price($state[7], 10);
			$new_states[] = $new_state;
		}
		// A up
		if($state[7] == 'A' && $state[3] == '.' && $state[4] == '.' && $state[5] == '.' && $state[11] == '.' && $state[12] == 'A') {
			$new_state = $state;
			$new_state[11] = $new_state[7];
			$new_state[7] = '.';
			$new_state[0] += price($state[7], 9);
			$new_states[] = $new_state;
		}
		// B down
		if($state[7] == 'B' && $state[4] == '.' && $state[5] == '.' && $state[21] == '.' && $state[22] == '.') {
			$new_state = $state;
			$new_state[22] = $new_state[7];
			$new_state[7] = '.';
			$new_state[0] += price($state[7], 8);
			$new_states[] = $new_state;
		}
		// B up
		if($state[7] == 'B' && $state[4] == '.' && $state[5] == '.' && $state[21] == '.' && $state[22] == 'B') {
			$new_state = $state;
			$new_state[21] = $new_state[7];
			$new_state[7] = '.';
			$new_state[0] += price($state[7], 7);
			$new_states[] = $new_state;
		}
		// C down
		if($state[7] == 'C' && $state[5] == '.' && $state[31] == '.' && $state[32] == '.') {
			$new_state = $state;
			$new_state[32] = $new_state[7];
			$new_state[7] = '.';
			$new_state[0] += price($state[7], 6);
			$new_states[] = $new_state;
		}
		// C up
		if($state[7] == 'C' && $state[5] == '.' && $state[31] == '.' && $state[32] == 'C') {
			$new_state = $state;
			$new_state[31] = $new_state[7];
			$new_state[7] = '.';
			$new_state[0] += price($state[7], 5);
			$new_states[] = $new_state;
		}
		// D down
		if($state[7] == 'D' && $state[41] == '.' && $state[42] == '.') {
			$new_state = $state;
			$new_state[42] = $new_state[7];
			$new_state[7] = '.';
			$new_state[0] += price($state[7], 4);
			$new_states[] = $new_state;
		}
		// D up
		if($state[7] == 'D' && $state[41] == '.' && $state[42] == 'D') {
			$new_state = $state;
			$new_state[41] = $new_state[7];
			$new_state[7] = '.';
			$new_state[0] += price($state[7], 3);
			$new_states[] = $new_state;
		}
	}
	return $new_states;
}

function new_states_2($state) {
	$new_states = array();
	// room 1 position 1 (up)
	if($state[11] != 'A' || $state[12] != 'A' || $state[13] != 'A' || $state[14] != 'A') {
		if($state[1] == '.' && $state[2] == '.' && $state[11] != '.') {
			$new_state = $state;
			$new_state[1] = $state[11];
			$new_state[11] = '.';
			$new_state[0] += price($state[11], 3);
			$new_states[] = $new_state;
		}
		if($state[2] == '.' && $state[11] != '.') {
			$new_state = $state;
			$new_state[2] = $state[11];
			$new_state[11] = '.';
			$new_state[0] += price($state[11], 2);
			$new_states[] = $new_state;
		}
		if($state[3] == '.' && $state[11] != '.') {
			$new_state = $state;
			$new_state[3] = $state[11];
			$new_state[11] = '.';
			$new_state[0] += price($state[11], 2);
			$new_states[] = $new_state;
		}
		if($state[3] == '.' && $state[4] == '.' && $state[11] != '.') {
			$new_state = $state;
			$new_state[4] = $state[11];
			$new_state[11] = '.';
			$new_state[0] += price($state[11], 4);
			$new_states[] = $new_state;
		}
		if($state[3] == '.' && $state[4] == '.' && $state[5] == '.' && $state[11] != '.') {
			$new_state = $state;
			$new_state[5] = $state[11];
			$new_state[11] = '.';
			$new_state[0] += price($state[11], 6);
			$new_states[] = $new_state;
		}
		if($state[3] == '.' && $state[4] == '.' && $state[5] == '.' && $state[6] == '.' && $state[11] != '.') {
			$new_state = $state;
			$new_state[6] = $state[11];
			$new_state[11] = '.';
			$new_state[0] += price($state[11], 8);
			$new_states[] = $new_state;
		}
		if($state[3] == '.' && $state[4] == '.' && $state[5] == '.' && $state[6] == '.' && $state[7] == '.' && $state[11] != '.') {
			$new_state = $state;
			$new_state[7] = $state[11];
			$new_state[11] = '.';
			$new_state[0] += price($state[11], 9);
			$new_states[] = $new_state;
		}
	}
	// room 2 position 1 (up)
	if($state[21] != 'B' || $state[22] != 'B' || $state[23] != 'B' || $state[24] != 'B') {
		if($state[1] == '.' && $state[2] == '.' && $state[3] == '.' && $state[21] != '.') {
			$new_state = $state;
			$new_state[1] = $state[21];
			$new_state[21] = '.';
			$new_state[0] += price($state[21], 5);
			$new_states[] = $new_state;
		}
		if($state[2] == '.' && $state[3] == '.' && $state[21] != '.') {
			$new_state = $state;
			$new_state[2] = $state[21];
			$new_state[21] = '.';
			$new_state[0] += price($state[21], 4);
			$new_states[] = $new_state;
		}
		if($state[3] == '.' && $state[21] != '.') {
			$new_state = $state;
			$new_state[3] = $state[21];
			$new_state[21] = '.';
			$new_state[0] += price($state[21], 2);
			$new_states[] = $new_state;
		}
		if($state[4] == '.' && $state[21] != '.') {
			$new_state = $state;
			$new_state[4] = $state[21];
			$new_state[21] = '.';
			$new_state[0] += price($state[21], 2);
			$new_states[] = $new_state;
		}
		if($state[4] == '.' && $state[5] == '.' && $state[21] != '.') {
			$new_state = $state;
			$new_state[5] = $state[21];
			$new_state[21] = '.';
			$new_state[0] += price($state[21], 4);
			$new_states[] = $new_state;
		}
		if($state[4] == '.' && $state[5] == '.' && $state[6] == '.' && $state[21] != '.') {
			$new_state = $state;
			$new_state[6] = $state[21];
			$new_state[21] = '.';
			$new_state[0] += price($state[21], 6);
			$new_states[] = $new_state;
		}
		if($state[4] == '.' && $state[5] == '.' && $state[6] == '.' && $state[7] == '.' && $state[21] != '.') {
			$new_state = $state;
			$new_state[7] = $state[21];
			$new_state[21] = '.';
			$new_state[0] += price($state[21], 7);
			$new_states[] = $new_state;
		}
	}
	// room 3 position 1 (up)
	if($state[31] != 'C' || $state[32] != 'C' || $state[33] != 'C' || $state[34] != 'C') {
		if($state[1] == '.' && $state[2] == '.' && $state[3] == '.' && $state[4] == '.' && $state[31] != '.') {
			$new_state = $state;
			$new_state[1] = $state[31];
			$new_state[31] = '.';
			$new_state[0] += price($state[31], 7);
			$new_states[] = $new_state;
		}
		if($state[2] == '.' && $state[3] == '.' && $state[4] == '.' && $state[31] != '.') {
			$new_state = $state;
			$new_state[2] = $state[31];
			$new_state[31] = '.';
			$new_state[0] += price($state[31], 6);
			$new_states[] = $new_state;
		}
		if($state[3] == '.' && $state[4] == '.' && $state[31] != '.') {
			$new_state = $state;
			$new_state[3] = $state[31];
			$new_state[31] = '.';
			$new_state[0] += price($state[31], 4);
			$new_states[] = $new_state;
		}
		if($state[4] == '.' && $state[31] != '.') {
			$new_state = $state;
			$new_state[4] = $state[31];
			$new_state[31] = '.';
			$new_state[0] += price($state[31], 2);
			$new_states[] = $new_state;
		}
		if($state[5] == '.' && $state[31] != '.') {
			$new_state = $state;
			$new_state[5] = $state[31];
			$new_state[31] = '.';
			$new_state[0] += price($state[31], 2);
			$new_states[] = $new_state;
		}
		if($state[5] == '.' && $state[6] == '.' && $state[31] != '.') {
			$new_state = $state;
			$new_state[6] = $state[31];
			$new_state[31] = '.';
			$new_state[0] += price($state[31], 4);
			$new_states[] = $new_state;
		}
		if($state[5] == '.' && $state[6] == '.' && $state[7] == '.' && $state[31] != '.') {
			$new_state = $state;
			$new_state[7] = $state[31];
			$new_state[31] = '.';
			$new_state[0] += price($state[31], 5);
			$new_states[] = $new_state;
		}
	}
	// room 4 position 1 (up)
	if($state[41] != 'D' || $state[42] != 'D' || $state[43] != 'D' || $state[44] != 'D') {
		if($state[1] == '.' && $state[2] == '.' && $state[3] == '.' && $state[4] == '.' && $state[5] == '.' && $state[41] != '.') {
			$new_state = $state;
			$new_state[1] = $state[41];
			$new_state[41] = '.';
			$new_state[0] += price($state[41], 9);
			$new_states[] = $new_state;
		}
		if($state[2] == '.' && $state[3] == '.' && $state[4] == '.' && $state[5] == '.' && $state[41] != '.') {
			$new_state = $state;
			$new_state[2] = $state[41];
			$new_state[41] = '.';
			$new_state[0] += price($state[41], 8);
			$new_states[] = $new_state;
		}
		if($state[3] == '.' && $state[4] == '.' && $state[5] == '.' && $state[41] != '.') {
			$new_state = $state;
			$new_state[3] = $state[41];
			$new_state[41] = '.';
			$new_state[0] += price($state[41], 6);
			$new_states[] = $new_state;
		}
		if($state[4] == '.' && $state[5] == '.' && $state[41] != '.') {
			$new_state = $state;
			$new_state[4] = $state[41];
			$new_state[41] = '.';
			$new_state[0] += price($state[41], 4);
			$new_states[] = $new_state;
		}
		if($state[5] == '.' && $state[41] != '.') {
			$new_state = $state;
			$new_state[5] = $state[41];
			$new_state[41] = '.';
			$new_state[0] += price($state[41], 2);
			$new_states[] = $new_state;
		}
		if($state[6] == '.' && $state[41] != '.') {
			$new_state = $state;
			$new_state[6] = $state[41];
			$new_state[41] = '.';
			$new_state[0] += price($state[41], 2);
			$new_states[] = $new_state;
		}
		if($state[6] == '.' && $state[7] == '.' && $state[41] != '.') {
			$new_state = $state;
			$new_state[7] = $state[41];
			$new_state[41] = '.';
			$new_state[0] += price($state[41], 3);
			$new_states[] = $new_state;
		}
	}
	// room 1 position 2 (middle up)
	if($state[11] == '.' && $state[12] != '.' && ($state[12] != 'A' || $state[13] != 'A' || $state[14] != 'A')) {
		if($state[1] == '.' && $state[2] == '.') {
			$new_state = $state;
			$new_state[1] = $state[12];
			$new_state[12] = '.';
			$new_state[0] += price($state[12], 4);
			$new_states[] = $new_state;
		}
		if($state[2] == '.') {
			$new_state = $state;
			$new_state[2] = $state[12];
			$new_state[12] = '.';
			$new_state[0] += price($state[12], 3);
			$new_states[] = $new_state;
		}
		if($state[3] == '.') {
			$new_state = $state;
			$new_state[3] = $state[12];
			$new_state[12] = '.';
			$new_state[0] += price($state[12], 3);
			$new_states[] = $new_state;
		}
		if($state[3] == '.' && $state[4] == '.') {
			$new_state = $state;
			$new_state[4] = $state[12];
			$new_state[12] = '.';
			$new_state[0] += price($state[12], 5);
			$new_states[] = $new_state;
		}
		if($state[3] == '.' && $state[4] == '.' && $state[5] == '.') {
			$new_state = $state;
			$new_state[5] = $state[12];
			$new_state[12] = '.';
			$new_state[0] += price($state[12], 7);
			$new_states[] = $new_state;
		}
		if($state[3] == '.' && $state[4] == '.' && $state[5] == '.' && $state[6] == '.') {
			$new_state = $state;
			$new_state[6] = $state[12];
			$new_state[12] = '.';
			$new_state[0] += price($state[12], 9);
			$new_states[] = $new_state;
		}
		if($state[3] == '.' && $state[4] == '.' && $state[5] == '.' && $state[6] == '.' && $state[7] == '.') {
			$new_state = $state;
			$new_state[7] = $state[12];
			$new_state[12] = '.';
			$new_state[0] += price($state[12], 10);
			$new_states[] = $new_state;
		}
	}
	// room 2 position 2 (middle up)
	if($state[21] == '.' && $state[22] != '.' && ($state[22] != 'B' || $state[23] != 'B' || $state[24] != 'B')) {
		if($state[1] == '.' && $state[2] == '.' && $state[3] == '.') {
			$new_state = $state;
			$new_state[1] = $state[22];
			$new_state[22] = '.';
			$new_state[0] += price($state[22], 6);
			$new_states[] = $new_state;
		}
		if($state[2] == '.' && $state[3] == '.') {
			$new_state = $state;
			$new_state[2] = $state[22];
			$new_state[22] = '.';
			$new_state[0] += price($state[22], 5);
			$new_states[] = $new_state;
		}
		if($state[3] == '.') {
			$new_state = $state;
			$new_state[3] = $state[22];
			$new_state[22] = '.';
			$new_state[0] += price($state[22], 3);
			$new_states[] = $new_state;
		}
		if($state[4] == '.') {
			$new_state = $state;
			$new_state[4] = $state[22];
			$new_state[22] = '.';
			$new_state[0] += price($state[22], 3);
			$new_states[] = $new_state;
		}
		if($state[4] == '.' && $state[5] == '.') {
			$new_state = $state;
			$new_state[5] = $state[22];
			$new_state[22] = '.';
			$new_state[0] += price($state[22], 5);
			$new_states[] = $new_state;
		}
		if($state[4] == '.' && $state[5] == '.' && $state[6] == '.') {
			$new_state = $state;
			$new_state[6] = $state[22];
			$new_state[22] = '.';
			$new_state[0] += price($state[22], 7);
			$new_states[] = $new_state;
		}
		if($state[4] == '.' && $state[5] == '.' && $state[6] == '.' && $state[7] == '.') {
			$new_state = $state;
			$new_state[7] = $state[22];
			$new_state[22] = '.';
			$new_state[0] += price($state[22], 8);
			$new_states[] = $new_state;
		}
	}
	// room 3 position 2 (middle up)
	if($state[31] == '.' && $state[32] != '.' && ($state[32] != 'C' || $state[33] != 'C' || $state[34] != 'C')) {
		if($state[1] == '.' && $state[2] == '.' && $state[3] == '.' && $state[4] == '.') {
			$new_state = $state;
			$new_state[1] = $state[32];
			$new_state[32] = '.';
			$new_state[0] += price($state[32], 8);
			$new_states[] = $new_state;
		}
		if($state[2] == '.' && $state[3] == '.' && $state[4] == '.') {
			$new_state = $state;
			$new_state[2] = $state[32];
			$new_state[32] = '.';
			$new_state[0] += price($state[32], 7);
			$new_states[] = $new_state;
		}
		if($state[3] == '.' && $state[4] == '.') {
			$new_state = $state;
			$new_state[3] = $state[32];
			$new_state[32] = '.';
			$new_state[0] += price($state[32], 5);
			$new_states[] = $new_state;
		}
		if($state[4] == '.') {
			$new_state = $state;
			$new_state[4] = $state[32];
			$new_state[32] = '.';
			$new_state[0] += price($state[32], 3);
			$new_states[] = $new_state;
		}
		if($state[5] == '.') {
			$new_state = $state;
			$new_state[5] = $state[32];
			$new_state[32] = '.';
			$new_state[0] += price($state[32], 3);
			$new_states[] = $new_state;
		}
		if($state[5] == '.' && $state[6] == '.') {
			$new_state = $state;
			$new_state[6] = $state[32];
			$new_state[32] = '.';
			$new_state[0] += price($state[32], 5);
			$new_states[] = $new_state;
		}
		if($state[5] == '.' && $state[6] == '.' && $state[7] == '.') {
			$new_state = $state;
			$new_state[7] = $state[32];
			$new_state[32] = '.';
			$new_state[0] += price($state[32], 6);
			$new_states[] = $new_state;
		}
	}
	// room 4 position 2 (middle up)
	if($state[41] == '.' && $state[42] != '.' && ($state[42] != 'D' || $state[43] != 'D' || $state[44] != 'D')) {
		if($state[1] == '.' && $state[2] == '.' && $state[3] == '.' && $state[4] == '.' && $state[5] == '.') {
			$new_state = $state;
			$new_state[1] = $state[42];
			$new_state[42] = '.';
			$new_state[0] += price($state[42], 10);
			$new_states[] = $new_state;
		}
		if($state[2] == '.' && $state[3] == '.' && $state[4] == '.' && $state[5] == '.') {
			$new_state = $state;
			$new_state[2] = $state[42];
			$new_state[42] = '.';
			$new_state[0] += price($state[42], 9);
			$new_states[] = $new_state;
		}
		if($state[3] == '.' && $state[4] == '.' && $state[5] == '.') {
			$new_state = $state;
			$new_state[3] = $state[42];
			$new_state[42] = '.';
			$new_state[0] += price($state[42], 7);
			$new_states[] = $new_state;
		}
		if($state[4] == '.' && $state[5] == '.') {
			$new_state = $state;
			$new_state[4] = $state[42];
			$new_state[42] = '.';
			$new_state[0] += price($state[42], 5);
			$new_states[] = $new_state;
		}
		if($state[5] == '.') {
			$new_state = $state;
			$new_state[5] = $state[42];
			$new_state[42] = '.';
			$new_state[0] += price($state[42], 3);
			$new_states[] = $new_state;
		}
		if($state[6] == '.') {
			$new_state = $state;
			$new_state[6] = $state[42];
			$new_state[42] = '.';
			$new_state[0] += price($state[42], 3);
			$new_states[] = $new_state;
		}
		if($state[6] == '.' && $state[7] == '.') {
			$new_state = $state;
			$new_state[7] = $state[42];
			$new_state[42] = '.';
			$new_state[0] += price($state[42], 4);
			$new_states[] = $new_state;
		}
	}
	// room 1 position 3 (middle down)
	if($state[11] == '.' && $state[12] == '.' && $state[13] != '.' && ($state[13] != 'A' || $state[14] != 'A')) {
		if($state[1] == '.' && $state[2] == '.') {
			$new_state = $state;
			$new_state[1] = $state[13];
			$new_state[13] = '.';
			$new_state[0] += price($state[13], 5);
			$new_states[] = $new_state;
		}
		if($state[2] == '.') {
			$new_state = $state;
			$new_state[2] = $state[13];
			$new_state[13] = '.';
			$new_state[0] += price($state[13], 4);
			$new_states[] = $new_state;
		}
		if($state[3] == '.') {
			$new_state = $state;
			$new_state[3] = $state[13];
			$new_state[13] = '.';
			$new_state[0] += price($state[13], 4);
			$new_states[] = $new_state;
		}
		if($state[3] == '.' && $state[4] == '.') {
			$new_state = $state;
			$new_state[4] = $state[13];
			$new_state[13] = '.';
			$new_state[0] += price($state[13], 6);
			$new_states[] = $new_state;
		}
		if($state[3] == '.' && $state[4] == '.' && $state[5] == '.') {
			$new_state = $state;
			$new_state[5] = $state[13];
			$new_state[13] = '.';
			$new_state[0] += price($state[13], 8);
			$new_states[] = $new_state;
		}
		if($state[3] == '.' && $state[4] == '.' && $state[5] == '.' && $state[6] == '.') {
			$new_state = $state;
			$new_state[6] = $state[13];
			$new_state[13] = '.';
			$new_state[0] += price($state[13], 10);
			$new_states[] = $new_state;
		}
		if($state[3] == '.' && $state[4] == '.' && $state[5] == '.' && $state[6] == '.' && $state[7] == '.') {
			$new_state = $state;
			$new_state[7] = $state[13];
			$new_state[13] = '.';
			$new_state[0] += price($state[13], 11);
			$new_states[] = $new_state;
		}
	}
	// room 2 position 3 (middle down)
	if($state[21] == '.' && $state[22] == '.' && $state[23] != '.' && ($state[23] != 'B' || $state[24] != 'B')) {
		if($state[1] == '.' && $state[2] == '.' && $state[3] == '.') {
			$new_state = $state;
			$new_state[1] = $state[23];
			$new_state[23] = '.';
			$new_state[0] += price($state[23], 7);
			$new_states[] = $new_state;
		}
		if($state[2] == '.' && $state[3] == '.') {
			$new_state = $state;
			$new_state[2] = $state[23];
			$new_state[23] = '.';
			$new_state[0] += price($state[23], 6);
			$new_states[] = $new_state;
		}
		if($state[3] == '.') {
			$new_state = $state;
			$new_state[3] = $state[23];
			$new_state[23] = '.';
			$new_state[0] += price($state[23], 4);
			$new_states[] = $new_state;
		}
		if($state[4] == '.') {
			$new_state = $state;
			$new_state[4] = $state[23];
			$new_state[23] = '.';
			$new_state[0] += price($state[23], 4);
			$new_states[] = $new_state;
		}
		if($state[4] == '.' && $state[5] == '.') {
			$new_state = $state;
			$new_state[5] = $state[23];
			$new_state[23] = '.';
			$new_state[0] += price($state[23], 6);
			$new_states[] = $new_state;
		}
		if($state[4] == '.' && $state[5] == '.' && $state[6] == '.') {
			$new_state = $state;
			$new_state[6] = $state[23];
			$new_state[23] = '.';
			$new_state[0] += price($state[23], 8);
			$new_states[] = $new_state;
		}
		if($state[4] == '.' && $state[5] == '.' && $state[6] == '.' && $state[7] == '.') {
			$new_state = $state;
			$new_state[7] = $state[23];
			$new_state[23] = '.';
			$new_state[0] += price($state[23], 9);
			$new_states[] = $new_state;
		}
	}
	// room 3 position 3 (middle down)
	if($state[31] == '.' && $state[32] == '.' && $state[33] != '.' && ($state[33] != 'C' || $state[34] != 'C')) {
		if($state[1] == '.' && $state[2] == '.' && $state[3] == '.' && $state[4] == '.') {
			$new_state = $state;
			$new_state[1] = $state[33];
			$new_state[33] = '.';
			$new_state[0] += price($state[33], 9);
			$new_states[] = $new_state;
		}
		if($state[2] == '.' && $state[3] == '.' && $state[4] == '.') {
			$new_state = $state;
			$new_state[2] = $state[33];
			$new_state[33] = '.';
			$new_state[0] += price($state[33], 8);
			$new_states[] = $new_state;
		}
		if($state[3] == '.' && $state[4] == '.') {
			$new_state = $state;
			$new_state[3] = $state[33];
			$new_state[33] = '.';
			$new_state[0] += price($state[33], 6);
			$new_states[] = $new_state;
		}
		if($state[4] == '.') {
			$new_state = $state;
			$new_state[4] = $state[33];
			$new_state[33] = '.';
			$new_state[0] += price($state[33], 4);
			$new_states[] = $new_state;
		}
		if($state[5] == '.') {
			$new_state = $state;
			$new_state[5] = $state[33];
			$new_state[33] = '.';
			$new_state[0] += price($state[33], 4);
			$new_states[] = $new_state;
		}
		if($state[5] == '.' && $state[6] == '.') {
			$new_state = $state;
			$new_state[6] = $state[33];
			$new_state[33] = '.';
			$new_state[0] += price($state[33], 6);
			$new_states[] = $new_state;
		}
		if($state[5] == '.' && $state[6] == '.' && $state[7] == '.') {
			$new_state = $state;
			$new_state[7] = $state[33];
			$new_state[33] = '.';
			$new_state[0] += price($state[33], 7);
			$new_states[] = $new_state;
		}
	}
	// room 4 position 3 (middle down)
	if($state[41] == '.' && $state[42] == '.' && $state[43] != '.' && ($state[43] != 'D' || $state[44] != 'D')) {
		if($state[1] == '.' && $state[2] == '.' && $state[3] == '.' && $state[4] == '.' && $state[5] == '.') {
			$new_state = $state;
			$new_state[1] = $state[43];
			$new_state[43] = '.';
			$new_state[0] += price($state[43], 11);
			$new_states[] = $new_state;
		}
		if($state[2] == '.' && $state[3] == '.' && $state[4] == '.' && $state[5] == '.') {
			$new_state = $state;
			$new_state[2] = $state[43];
			$new_state[43] = '.';
			$new_state[0] += price($state[43], 10);
			$new_states[] = $new_state;
		}
		if($state[3] == '.' && $state[4] == '.' && $state[5] == '.') {
			$new_state = $state;
			$new_state[3] = $state[43];
			$new_state[43] = '.';
			$new_state[0] += price($state[43], 8);
			$new_states[] = $new_state;
		}
		if($state[4] == '.' && $state[5] == '.') {
			$new_state = $state;
			$new_state[4] = $state[43];
			$new_state[43] = '.';
			$new_state[0] += price($state[43], 6);
			$new_states[] = $new_state;
		}
		if($state[5] == '.') {
			$new_state = $state;
			$new_state[5] = $state[43];
			$new_state[43] = '.';
			$new_state[0] += price($state[43], 4);
			$new_states[] = $new_state;
		}
		if($state[6] == '.') {
			$new_state = $state;
			$new_state[6] = $state[43];
			$new_state[43] = '.';
			$new_state[0] += price($state[43], 4);
			$new_states[] = $new_state;
		}
		if($state[6] == '.' && $state[7] == '.') {
			$new_state = $state;
			$new_state[7] = $state[43];
			$new_state[43] = '.';
			$new_state[0] += price($state[43], 5);
			$new_states[] = $new_state;
		}
	}
	// room 1 position 4 (down)
	if($state[11] == '.' && $state[12] == '.' && $state[13] == '.' && $state[14] != '.' && $state[14] != 'A') {
		if($state[1] == '.' && $state[2] == '.') {
			$new_state = $state;
			$new_state[1] = $state[14];
			$new_state[14] = '.';
			$new_state[0] += price($state[14], 6);
			$new_states[] = $new_state;
		}
		if($state[2] == '.') {
			$new_state = $state;
			$new_state[2] = $state[14];
			$new_state[14] = '.';
			$new_state[0] += price($state[14], 5);
			$new_states[] = $new_state;
		}
		if($state[3] == '.') {
			$new_state = $state;
			$new_state[3] = $state[14];
			$new_state[14] = '.';
			$new_state[0] += price($state[14], 5);
			$new_states[] = $new_state;
		}
		if($state[3] == '.' && $state[4] == '.') {
			$new_state = $state;
			$new_state[4] = $state[14];
			$new_state[14] = '.';
			$new_state[0] += price($state[14], 7);
			$new_states[] = $new_state;
		}
		if($state[3] == '.' && $state[4] == '.' && $state[5] == '.') {
			$new_state = $state;
			$new_state[5] = $state[14];
			$new_state[14] = '.';
			$new_state[0] += price($state[14], 9);
			$new_states[] = $new_state;
		}
		if($state[3] == '.' && $state[4] == '.' && $state[5] == '.' && $state[6] == '.') {
			$new_state = $state;
			$new_state[6] = $state[14];
			$new_state[14] = '.';
			$new_state[0] += price($state[14], 11);
			$new_states[] = $new_state;
		}
		if($state[3] == '.' && $state[4] == '.' && $state[5] == '.' && $state[6] == '.' && $state[7] == '.') {
			$new_state = $state;
			$new_state[7] = $state[14];
			$new_state[14] = '.';
			$new_state[0] += price($state[14], 12);
			$new_states[] = $new_state;
		}
	}
	// room 2 position 4 (down)
	if($state[21] == '.' && $state[22] == '.' && $state[23] == '.' && $state[24] != '.' && $state[24] != 'B') {
		if($state[1] == '.' && $state[2] == '.' && $state[3] == '.') {
			$new_state = $state;
			$new_state[1] = $state[24];
			$new_state[24] = '.';
			$new_state[0] += price($state[24], 8);
			$new_states[] = $new_state;
		}
		if($state[2] == '.' && $state[3] == '.') {
			$new_state = $state;
			$new_state[2] = $state[24];
			$new_state[24] = '.';
			$new_state[0] += price($state[24], 7);
			$new_states[] = $new_state;
		}
		if($state[3] == '.') {
			$new_state = $state;
			$new_state[3] = $state[24];
			$new_state[24] = '.';
			$new_state[0] += price($state[24], 5);
			$new_states[] = $new_state;
		}
		if($state[4] == '.') {
			$new_state = $state;
			$new_state[4] = $state[24];
			$new_state[24] = '.';
			$new_state[0] += price($state[24], 5);
			$new_states[] = $new_state;
		}
		if($state[4] == '.' && $state[5] == '.') {
			$new_state = $state;
			$new_state[5] = $state[24];
			$new_state[24] = '.';
			$new_state[0] += price($state[24], 7);
			$new_states[] = $new_state;
		}
		if($state[4] == '.' && $state[5] == '.' && $state[6] == '.') {
			$new_state = $state;
			$new_state[6] = $state[24];
			$new_state[24] = '.';
			$new_state[0] += price($state[24], 9);
			$new_states[] = $new_state;
		}
		if($state[4] == '.' && $state[5] == '.' && $state[6] == '.' && $state[7] == '.') {
			$new_state = $state;
			$new_state[7] = $state[24];
			$new_state[24] = '.';
			$new_state[0] += price($state[24], 10);
			$new_states[] = $new_state;
		}
	}
	// room 3 position 4 (down)
	if($state[31] == '.' && $state[32] == '.' && $state[33] == '.' && $state[34] != '.' && $state[34] != 'C') {
		if($state[1] == '.' && $state[2] == '.' && $state[3] == '.' && $state[4] == '.') {
			$new_state = $state;
			$new_state[1] = $state[34];
			$new_state[34] = '.';
			$new_state[0] += price($state[34], 10);
			$new_states[] = $new_state;
		}
		if($state[2] == '.' && $state[3] == '.' && $state[4] == '.') {
			$new_state = $state;
			$new_state[2] = $state[34];
			$new_state[34] = '.';
			$new_state[0] += price($state[34], 9);
			$new_states[] = $new_state;
		}
		if($state[3] == '.' && $state[4] == '.') {
			$new_state = $state;
			$new_state[3] = $state[34];
			$new_state[34] = '.';
			$new_state[0] += price($state[34], 7);
			$new_states[] = $new_state;
		}
		if($state[4] == '.') {
			$new_state = $state;
			$new_state[4] = $state[34];
			$new_state[34] = '.';
			$new_state[0] += price($state[34], 5);
			$new_states[] = $new_state;
		}
		if($state[5] == '.') {
			$new_state = $state;
			$new_state[5] = $state[34];
			$new_state[34] = '.';
			$new_state[0] += price($state[34], 5);
			$new_states[] = $new_state;
		}
		if($state[5] == '.' && $state[6] == '.') {
			$new_state = $state;
			$new_state[6] = $state[34];
			$new_state[34] = '.';
			$new_state[0] += price($state[34], 7);
			$new_states[] = $new_state;
		}
		if($state[5] == '.' && $state[6] == '.' && $state[7] == '.') {
			$new_state = $state;
			$new_state[7] = $state[34];
			$new_state[34] = '.';
			$new_state[0] += price($state[34], 8);
			$new_states[] = $new_state;
		}
	}
	// room 4 position 4 (down)
	if($state[41] == '.' && $state[42] == '.' && $state[43] == '.' && $state[44] != '.' && $state[44] != 'D') {
		if($state[1] == '.' && $state[2] == '.' && $state[3] == '.' && $state[4] == '.' && $state[5] == '.') {
			$new_state = $state;
			$new_state[1] = $state[44];
			$new_state[44] = '.';
			$new_state[0] += price($state[44], 12);
			$new_states[] = $new_state;
		}
		if($state[2] == '.' && $state[3] == '.' && $state[4] == '.' && $state[5] == '.') {
			$new_state = $state;
			$new_state[2] = $state[44];
			$new_state[44] = '.';
			$new_state[0] += price($state[44], 11);
			$new_states[] = $new_state;
		}
		if($state[3] == '.' && $state[4] == '.' && $state[5] == '.') {
			$new_state = $state;
			$new_state[3] = $state[44];
			$new_state[44] = '.';
			$new_state[0] += price($state[44], 9);
			$new_states[] = $new_state;
		}
		if($state[4] == '.' && $state[5] == '.') {
			$new_state = $state;
			$new_state[4] = $state[44];
			$new_state[44] = '.';
			$new_state[0] += price($state[44], 7);
			$new_states[] = $new_state;
		}
		if($state[5] == '.') {
			$new_state = $state;
			$new_state[5] = $state[44];
			$new_state[44] = '.';
			$new_state[0] += price($state[44], 5);
			$new_states[] = $new_state;
		}
		if($state[6] == '.') {
			$new_state = $state;
			$new_state[6] = $state[44];
			$new_state[44] = '.';
			$new_state[0] += price($state[44], 5);
			$new_states[] = $new_state;
		}
		if($state[6] == '.' && $state[7] == '.') {
			$new_state = $state;
			$new_state[7] = $state[44];
			$new_state[44] = '.';
			$new_state[0] += price($state[44], 6);
			$new_states[] = $new_state;
		}
	}

	// hallway position 1
	if($state[1] != '.' && $state[2] == '.') {
		// A position 1 (up)
		if($state[1] == 'A' && $state[11] == '.' && $state[12] == 'A' && $state[13] == 'A' && $state[14] == 'A') {
			$new_state = $state;
			$new_state[11] = $new_state[1];
			$new_state[1] = '.';
			$new_state[0] += price($state[1], 3);
			$new_states[] = $new_state;
		}
		// A position 2 (middle up)
		if($state[1] == 'A' && $state[11] == '.' && $state[12] == '.' && $state[13] == 'A' && $state[14] == 'A') {
			$new_state = $state;
			$new_state[12] = $new_state[1];
			$new_state[1] = '.';
			$new_state[0] += price($state[1], 4);
			$new_states[] = $new_state;
		}
		// A position 3 (middle down)
		if($state[1] == 'A' && $state[11] == '.' && $state[12] == '.' && $state[13] == '.' && $state[14] == 'A') {
			$new_state = $state;
			$new_state[13] = $new_state[1];
			$new_state[1] = '.';
			$new_state[0] += price($state[1], 5);
			$new_states[] = $new_state;
		}
		// A position 4 (down)
		if($state[1] == 'A' && $state[11] == '.' && $state[12] == '.' && $state[13] == '.' && $state[14] == '.') {
			$new_state = $state;
			$new_state[14] = $new_state[1];
			$new_state[1] = '.';
			$new_state[0] += price($state[1], 6);
			$new_states[] = $new_state;
		}
		// B position 1 (up)
		if($state[1] == 'B' && $state[3] == '.' && $state[21] == '.' && $state[22] == 'B' && $state[23] == 'B' && $state[24] == 'B') {
			$new_state = $state;
			$new_state[21] = $new_state[1];
			$new_state[1] = '.';
			$new_state[0] += price($state[1], 5);
			$new_states[] = $new_state;
		}
		// B position 2 (middle up)
		if($state[1] == 'B' && $state[3] == '.' && $state[21] == '.' && $state[22] == '.' && $state[23] == 'B' && $state[24] == 'B') {
			$new_state = $state;
			$new_state[22] = $new_state[1];
			$new_state[1] = '.';
			$new_state[0] += price($state[1], 6);
			$new_states[] = $new_state;
		}
		// B position 3 (middle down)
		if($state[1] == 'B' && $state[3] == '.' && $state[21] == '.' && $state[22] == '.' && $state[23] == '.' && $state[24] == 'B') {
			$new_state = $state;
			$new_state[23] = $new_state[1];
			$new_state[1] = '.';
			$new_state[0] += price($state[1], 7);
			$new_states[] = $new_state;
		}
		// B position 4 (down)
		if($state[1] == 'B' && $state[3] == '.' && $state[21] == '.' && $state[22] == '.' && $state[23] == '.' && $state[24] == '.') {
			$new_state = $state;
			$new_state[24] = $new_state[1];
			$new_state[1] = '.';
			$new_state[0] += price($state[1], 8);
			$new_states[] = $new_state;
		}
		// C position 1 (up)
		if($state[1] == 'C' && $state[3] == '.' && $state[4] == '.' && $state[31] == '.' && $state[32] == 'C' && $state[33] == 'C' && $state[34] == 'C') {
			$new_state = $state;
			$new_state[31] = $new_state[1];
			$new_state[1] = '.';
			$new_state[0] += price($state[1], 7);
			$new_states[] = $new_state;
		}
		// C position 2 (middle up)
		if($state[1] == 'C' && $state[3] == '.' && $state[4] == '.' && $state[31] == '.' && $state[32] == '.' && $state[33] == 'C' && $state[34] == 'C') {
			$new_state = $state;
			$new_state[32] = $new_state[1];
			$new_state[1] = '.';
			$new_state[0] += price($state[1], 8);
			$new_states[] = $new_state;
		}
		// C position 3 (middle down)
		if($state[1] == 'C' && $state[3] == '.' && $state[4] == '.' && $state[31] == '.' && $state[32] == '.' && $state[33] == '.' && $state[34] == 'C') {
			$new_state = $state;
			$new_state[33] = $new_state[1];
			$new_state[1] = '.';
			$new_state[0] += price($state[1], 9);
			$new_states[] = $new_state;
		}
		// C position 4 (down)
		if($state[1] == 'C' && $state[3] == '.' && $state[4] == '.' && $state[31] == '.' && $state[32] == '.' && $state[33] == '.' && $state[34] == '.') {
			$new_state = $state;
			$new_state[34] = $new_state[1];
			$new_state[1] = '.';
			$new_state[0] += price($state[1], 10);
			$new_states[] = $new_state;
		}
		// D position 1 (up)
		if($state[1] == 'D' && $state[3] == '.' && $state[4] == '.' && $state[5] == '.' && $state[41] == '.' && $state[42] == 'D' && $state[43] == 'D' && $state[44] == 'D') {
			$new_state = $state;
			$new_state[41] = $new_state[1];
			$new_state[1] = '.';
			$new_state[0] += price($state[1], 9);
			$new_states[] = $new_state;
		}
		// D position 2 (middle up)
		if($state[1] == 'D' && $state[3] == '.' && $state[4] == '.' && $state[5] == '.' && $state[41] == '.' && $state[42] == '.' && $state[43] == 'D' && $state[44] == 'D') {
			$new_state = $state;
			$new_state[42] = $new_state[1];
			$new_state[1] = '.';
			$new_state[0] += price($state[1], 10);
			$new_states[] = $new_state;
		}
		// D position 3 (middle down)
		if($state[1] == 'D' && $state[3] == '.' && $state[4] == '.' && $state[5] == '.' && $state[41] == '.' && $state[42] == '.' && $state[43] == '.' && $state[44] == 'D') {
			$new_state = $state;
			$new_state[43] = $new_state[1];
			$new_state[1] = '.';
			$new_state[0] += price($state[1], 11);
			$new_states[] = $new_state;
		}
		// D position 4 (down)
		if($state[1] == 'D' && $state[3] == '.' && $state[4] == '.' && $state[5] == '.' && $state[41] == '.' && $state[42] == '.' && $state[43] == '.' && $state[44] == '.') {
			$new_state = $state;
			$new_state[44] = $new_state[1];
			$new_state[1] = '.';
			$new_state[0] += price($state[1], 12);
			$new_states[] = $new_state;
		}
	}
	// hallway position 2
	if($state[2] != '.') {
		// A position 1 (up)
		if($state[2] == 'A' && $state[11] == '.' && $state[12] == 'A' && $state[13] == 'A' && $state[14] == 'A') {
			$new_state = $state;
			$new_state[11] = $new_state[2];
			$new_state[2] = '.';
			$new_state[0] += price($state[2], 2);
			$new_states[] = $new_state;
		}
		// A position 2 (middle up)
		if($state[2] == 'A' && $state[11] == '.' && $state[12] == '.' && $state[13] == 'A' && $state[14] == 'A') {
			$new_state = $state;
			$new_state[12] = $new_state[2];
			$new_state[2] = '.';
			$new_state[0] += price($state[2], 3);
			$new_states[] = $new_state;
		}
		// A position 3 (middle down)
		if($state[2] == 'A' && $state[11] == '.' && $state[12] == '.' && $state[13] == '.' && $state[14] == 'A') {
			$new_state = $state;
			$new_state[13] = $new_state[2];
			$new_state[2] = '.';
			$new_state[0] += price($state[2], 4);
			$new_states[] = $new_state;
		}
		// A position 4 (down)
		if($state[2] == 'A' && $state[11] == '.' && $state[12] == '.' && $state[13] == '.' && $state[14] == '.') {
			$new_state = $state;
			$new_state[14] = $new_state[2];
			$new_state[2] = '.';
			$new_state[0] += price($state[2], 5);
			$new_states[] = $new_state;
		}
		// B position 1 (up)
		if($state[2] == 'B' && $state[3] == '.' && $state[21] == '.' && $state[22] == 'B' && $state[23] == 'B' && $state[24] == 'B') {
			$new_state = $state;
			$new_state[21] = $new_state[2];
			$new_state[2] = '.';
			$new_state[0] += price($state[2], 4);
			$new_states[] = $new_state;
		}
		// B position 2 (middle up)
		if($state[2] == 'B' && $state[3] == '.' && $state[21] == '.' && $state[22] == '.' && $state[23] == 'B' && $state[24] == 'B') {
			$new_state = $state;
			$new_state[22] = $new_state[2];
			$new_state[2] = '.';
			$new_state[0] += price($state[2], 5);
			$new_states[] = $new_state;
		}
		// B position 3 (middle down)
		if($state[2] == 'B' && $state[3] == '.' && $state[21] == '.' && $state[22] == '.' && $state[23] == '.' && $state[24] == 'B') {
			$new_state = $state;
			$new_state[23] = $new_state[2];
			$new_state[2] = '.';
			$new_state[0] += price($state[2], 6);
			$new_states[] = $new_state;
		}
		// B position 4 (down)
		if($state[2] == 'B' && $state[3] == '.' && $state[21] == '.' && $state[22] == '.' && $state[23] == '.' && $state[24] == '.') {
			$new_state = $state;
			$new_state[24] = $new_state[2];
			$new_state[2] = '.';
			$new_state[0] += price($state[2], 7);
			$new_states[] = $new_state;
		}
		// C position 1 (up)
		if($state[2] == 'C' && $state[3] == '.' && $state[4] == '.' && $state[31] == '.' && $state[32] == 'C' && $state[33] == 'C' && $state[34] == 'C') {
			$new_state = $state;
			$new_state[31] = $new_state[2];
			$new_state[2] = '.';
			$new_state[0] += price($state[2], 6);
			$new_states[] = $new_state;
		}
		// C position 2 (middle up)
		if($state[2] == 'C' && $state[3] == '.' && $state[4] == '.' && $state[31] == '.' && $state[32] == '.' && $state[33] == 'C' && $state[34] == 'C') {
			$new_state = $state;
			$new_state[32] = $new_state[2];
			$new_state[2] = '.';
			$new_state[0] += price($state[2], 7);
			$new_states[] = $new_state;
		}
		// C position 3 (middle down)
		if($state[2] == 'C' && $state[3] == '.' && $state[4] == '.' && $state[31] == '.' && $state[32] == '.' && $state[33] == '.' && $state[34] == 'C') {
			$new_state = $state;
			$new_state[33] = $new_state[2];
			$new_state[2] = '.';
			$new_state[0] += price($state[2], 8);
			$new_states[] = $new_state;
		}
		// C position 4 (down)
		if($state[2] == 'C' && $state[3] == '.' && $state[4] == '.' && $state[31] == '.' && $state[32] == '.' && $state[33] == '.' && $state[34] == '.') {
			$new_state = $state;
			$new_state[34] = $new_state[2];
			$new_state[2] = '.';
			$new_state[0] += price($state[2], 9);
			$new_states[] = $new_state;
		}
		// D position 1 (up)
		if($state[2] == 'D' && $state[3] == '.' && $state[4] == '.' && $state[5] == '.' && $state[41] == '.' && $state[42] == 'D' && $state[43] == 'D' && $state[44] == 'D') {
			$new_state = $state;
			$new_state[41] = $new_state[2];
			$new_state[2] = '.';
			$new_state[0] += price($state[2], 8);
			$new_states[] = $new_state;
		}
		// D position 2 (middle up)
		if($state[2] == 'D' && $state[3] == '.' && $state[4] == '.' && $state[5] == '.' && $state[41] == '.' && $state[42] == '.' && $state[43] == 'D' && $state[44] == 'D') {
			$new_state = $state;
			$new_state[42] = $new_state[2];
			$new_state[2] = '.';
			$new_state[0] += price($state[2], 9);
			$new_states[] = $new_state;
		}
		// D position 3 (middle down)
		if($state[2] == 'D' && $state[3] == '.' && $state[4] == '.' && $state[5] == '.' && $state[41] == '.' && $state[42] == '.' && $state[43] == '.' && $state[44] == 'D') {
			$new_state = $state;
			$new_state[43] = $new_state[2];
			$new_state[2] = '.';
			$new_state[0] += price($state[2], 10);
			$new_states[] = $new_state;
		}
		// D position 4 (down)
		if($state[2] == 'D' && $state[3] == '.' && $state[4] == '.' && $state[5] == '.' && $state[41] == '.' && $state[42] == '.' && $state[43] == '.' && $state[44] == '.') {
			$new_state = $state;
			$new_state[44] = $new_state[2];
			$new_state[2] = '.';
			$new_state[0] += price($state[2], 11);
			$new_states[] = $new_state;
		}
	}
	// hallway position 3
	if($state[3] != '.') {
		// A position 1 (up)
		if($state[3] == 'A' && $state[11] == '.' && $state[12] == 'A' && $state[13] == 'A' && $state[14] == 'A') {
			$new_state = $state;
			$new_state[11] = $new_state[3];
			$new_state[3] = '.';
			$new_state[0] += price($state[3], 2);
			$new_states[] = $new_state;
		}
		// A position 2 (middle up)
		if($state[3] == 'A' && $state[11] == '.' && $state[12] == '.' && $state[13] == 'A' && $state[14] == 'A') {
			$new_state = $state;
			$new_state[12] = $new_state[3];
			$new_state[3] = '.';
			$new_state[0] += price($state[3], 3);
			$new_states[] = $new_state;
		}
		// A position 3 (middle down)
		if($state[3] == 'A' && $state[11] == '.' && $state[12] == '.' && $state[13] == '.' && $state[14] == 'A') {
			$new_state = $state;
			$new_state[13] = $new_state[3];
			$new_state[3] = '.';
			$new_state[0] += price($state[3], 4);
			$new_states[] = $new_state;
		}
		// A position 4 (down)
		if($state[3] == 'A' && $state[11] == '.' && $state[12] == '.' && $state[13] == '.' && $state[14] == '.') {
			$new_state = $state;
			$new_state[14] = $new_state[3];
			$new_state[3] = '.';
			$new_state[0] += price($state[3], 5);
			$new_states[] = $new_state;
		}
		// B position 1 (up)
		if($state[3] == 'B' && $state[21] == '.' && $state[22] == 'B' && $state[23] == 'B' && $state[24] == 'B') {
			$new_state = $state;
			$new_state[21] = $new_state[3];
			$new_state[3] = '.';
			$new_state[0] += price($state[3], 2);
			$new_states[] = $new_state;
		}
		// B position 2 (middle up)
		if($state[3] == 'B' && $state[21] == '.' && $state[22] == '.' && $state[23] == 'B' && $state[24] == 'B') {
			$new_state = $state;
			$new_state[22] = $new_state[3];
			$new_state[3] = '.';
			$new_state[0] += price($state[3], 3);
			$new_states[] = $new_state;
		}
		// B position 3 (middle down)
		if($state[3] == 'B' && $state[21] == '.' && $state[22] == '.' && $state[23] == '.' && $state[24] == 'B') {
			$new_state = $state;
			$new_state[23] = $new_state[3];
			$new_state[3] = '.';
			$new_state[0] += price($state[3], 4);
			$new_states[] = $new_state;
		}
		// B position 4 (down)
		if($state[3] == 'B' && $state[21] == '.' && $state[22] == '.' && $state[23] == '.' && $state[24] == '.') {
			$new_state = $state;
			$new_state[24] = $new_state[3];
			$new_state[3] = '.';
			$new_state[0] += price($state[3], 5);
			$new_states[] = $new_state;
		}
		// C position 1 (up)
		if($state[3] == 'C' && $state[4] == '.' && $state[31] == '.' && $state[32] == 'C' && $state[33] == 'C' && $state[34] == 'C') {
			$new_state = $state;
			$new_state[31] = $new_state[3];
			$new_state[3] = '.';
			$new_state[0] += price($state[3], 4);
			$new_states[] = $new_state;
		}
		// C position 2 (middle up)
		if($state[3] == 'C' && $state[4] == '.' && $state[31] == '.' && $state[32] == '.' && $state[33] == 'C' && $state[34] == 'C') {
			$new_state = $state;
			$new_state[32] = $new_state[3];
			$new_state[3] = '.';
			$new_state[0] += price($state[3], 5);
			$new_states[] = $new_state;
		}
		// C position 3 (middle down)
		if($state[3] == 'C' && $state[4] == '.' && $state[31] == '.' && $state[32] == '.' && $state[33] == '.' && $state[34] == 'C') {
			$new_state = $state;
			$new_state[33] = $new_state[3];
			$new_state[3] = '.';
			$new_state[0] += price($state[3], 6);
			$new_states[] = $new_state;
		}
		// C position 4 (down)
		if($state[3] == 'C' && $state[4] == '.' && $state[31] == '.' && $state[32] == '.' && $state[33] == '.' && $state[34] == '.') {
			$new_state = $state;
			$new_state[34] = $new_state[3];
			$new_state[3] = '.';
			$new_state[0] += price($state[3], 7);
			$new_states[] = $new_state;
		}
		// D position 1 (up)
		if($state[3] == 'D' && $state[4] == '.' && $state[5] == '.' && $state[41] == '.' && $state[42] == 'D' && $state[43] == 'D' && $state[44] == 'D') {
			$new_state = $state;
			$new_state[41] = $new_state[3];
			$new_state[3] = '.';
			$new_state[0] += price($state[3], 6);
			$new_states[] = $new_state;
		}
		// D position 2 (middle up)
		if($state[3] == 'D' && $state[4] == '.' && $state[5] == '.' && $state[41] == '.' && $state[42] == '.' && $state[43] == 'D' && $state[44] == 'D') {
			$new_state = $state;
			$new_state[42] = $new_state[3];
			$new_state[3] = '.';
			$new_state[0] += price($state[3], 7);
			$new_states[] = $new_state;
		}
		// D position 3 (middle down)
		if($state[3] == 'D' && $state[4] == '.' && $state[5] == '.' && $state[41] == '.' && $state[42] == '.' && $state[43] == '.' && $state[44] == 'D') {
			$new_state = $state;
			$new_state[43] = $new_state[3];
			$new_state[3] = '.';
			$new_state[0] += price($state[3], 8);
			$new_states[] = $new_state;
		}
		// D position 4 (down)
		if($state[3] == 'D' && $state[4] == '.' && $state[5] == '.' && $state[41] == '.' && $state[42] == '.' && $state[43] == '.' && $state[44] == '.') {
			$new_state = $state;
			$new_state[44] = $new_state[3];
			$new_state[3] = '.';
			$new_state[0] += price($state[3], 9);
			$new_states[] = $new_state;
		}
	}
	// hallway position 4
	if($state[4] != '.') {
		// A position 1 (up)
		if($state[4] == 'A' && $state[3] == '.' && $state[11] == '.' && $state[12] == 'A' && $state[13] == 'A' && $state[14] == 'A') {
			$new_state = $state;
			$new_state[11] = $new_state[4];
			$new_state[4] = '.';
			$new_state[0] += price($state[4], 4);
			$new_states[] = $new_state;
		}
		// A position 2 (middle up)
		if($state[4] == 'A' && $state[3] == '.' && $state[11] == '.' && $state[12] == '.' && $state[13] == 'A' && $state[14] == 'A') {
			$new_state = $state;
			$new_state[12] = $new_state[4];
			$new_state[4] = '.';
			$new_state[0] += price($state[4], 5);
			$new_states[] = $new_state;
		}
		// A position 3 (middle down)
		if($state[4] == 'A' && $state[3] == '.' && $state[11] == '.' && $state[12] == '.' && $state[13] == '.' && $state[14] == 'A') {
			$new_state = $state;
			$new_state[13] = $new_state[4];
			$new_state[4] = '.';
			$new_state[0] += price($state[4], 6);
			$new_states[] = $new_state;
		}
		// A position 4 (down)
		if($state[4] == 'A' && $state[3] == '.' && $state[11] == '.' && $state[12] == '.' && $state[13] == '.' && $state[14] == '.') {
			$new_state = $state;
			$new_state[14] = $new_state[4];
			$new_state[4] = '.';
			$new_state[0] += price($state[4], 7);
			$new_states[] = $new_state;
		}
		// B position 1 (up)
		if($state[4] == 'B' && $state[21] == '.' && $state[22] == 'B' && $state[23] == 'B' && $state[24] == 'B') {
			$new_state = $state;
			$new_state[21] = $new_state[4];
			$new_state[4] = '.';
			$new_state[0] += price($state[4], 2);
			$new_states[] = $new_state;
		}
		// B position 2 (middle up)
		if($state[4] == 'B' && $state[21] == '.' && $state[22] == '.' && $state[23] == 'B' && $state[24] == 'B') {
			$new_state = $state;
			$new_state[22] = $new_state[4];
			$new_state[4] = '.';
			$new_state[0] += price($state[4], 3);
			$new_states[] = $new_state;
		}
		// B position 3 (middle down)
		if($state[4] == 'B' && $state[21] == '.' && $state[22] == '.' && $state[23] == '.' && $state[24] == 'B') {
			$new_state = $state;
			$new_state[23] = $new_state[4];
			$new_state[4] = '.';
			$new_state[0] += price($state[4], 4);
			$new_states[] = $new_state;
		}
		// B position 4 (down)
		if($state[4] == 'B' && $state[21] == '.' && $state[22] == '.' && $state[23] == '.' && $state[24] == '.') {
			$new_state = $state;
			$new_state[24] = $new_state[4];
			$new_state[4] = '.';
			$new_state[0] += price($state[4], 5);
			$new_states[] = $new_state;
		}
		// C position 1 (up)
		if($state[4] == 'C' && $state[31] == '.' && $state[32] == 'C' && $state[33] == 'C' && $state[34] == 'C') {
			$new_state = $state;
			$new_state[31] = $new_state[4];
			$new_state[4] = '.';
			$new_state[0] += price($state[4], 2);
			$new_states[] = $new_state;
		}
		// C position 2 (middle up)
		if($state[4] == 'C' && $state[31] == '.' && $state[32] == '.' && $state[33] == 'C' && $state[34] == 'C') {
			$new_state = $state;
			$new_state[32] = $new_state[4];
			$new_state[4] = '.';
			$new_state[0] += price($state[4], 3);
			$new_states[] = $new_state;
		}
		// C position 3 (middle down)
		if($state[4] == 'C' && $state[31] == '.' && $state[32] == '.' && $state[33] == '.' && $state[34] == 'C') {
			$new_state = $state;
			$new_state[33] = $new_state[4];
			$new_state[4] = '.';
			$new_state[0] += price($state[4], 4);
			$new_states[] = $new_state;
		}
		// C position 4 (down)
		if($state[4] == 'C' && $state[31] == '.' && $state[32] == '.' && $state[33] == '.' && $state[34] == '.') {
			$new_state = $state;
			$new_state[34] = $new_state[4];
			$new_state[4] = '.';
			$new_state[0] += price($state[4], 5);
			$new_states[] = $new_state;
		}
		// D position 1 (up)
		if($state[4] == 'D' && $state[5] == '.' && $state[41] == '.' && $state[42] == 'D' && $state[43] == 'D' && $state[44] == 'D') {
			$new_state = $state;
			$new_state[41] = $new_state[4];
			$new_state[4] = '.';
			$new_state[0] += price($state[4], 4);
			$new_states[] = $new_state;
		}
		// D position 2 (middle up)
		if($state[4] == 'D' && $state[5] == '.' && $state[41] == '.' && $state[42] == '.' && $state[43] == 'D' && $state[44] == 'D') {
			$new_state = $state;
			$new_state[42] = $new_state[4];
			$new_state[4] = '.';
			$new_state[0] += price($state[4], 5);
			$new_states[] = $new_state;
		}
		// D position 3 (middle down)
		if($state[4] == 'D' && $state[5] == '.' && $state[41] == '.' && $state[42] == '.' && $state[43] == '.' && $state[44] == 'D') {
			$new_state = $state;
			$new_state[43] = $new_state[4];
			$new_state[4] = '.';
			$new_state[0] += price($state[4], 6);
			$new_states[] = $new_state;
		}
		// D position 4 (down)
		if($state[4] == 'D' && $state[5] == '.' && $state[41] == '.' && $state[42] == '.' && $state[43] == '.' && $state[44] == '.') {
			$new_state = $state;
			$new_state[44] = $new_state[4];
			$new_state[4] = '.';
			$new_state[0] += price($state[4], 7);
			$new_states[] = $new_state;
		}
	}
	// hallway position 5
	if($state[5] != '.') {
		// A position 1 (up)
		if($state[5] == 'A' && $state[3] == '.' && $state[4] == '.' && $state[11] == '.' && $state[12] == 'A' && $state[13] == 'A' && $state[14] == 'A') {
			$new_state = $state;
			$new_state[11] = $new_state[5];
			$new_state[5] = '.';
			$new_state[0] += price($state[5], 6);
			$new_states[] = $new_state;
		}
		// A position 2 (middle up)
		if($state[5] == 'A' && $state[3] == '.' && $state[4] == '.' && $state[11] == '.' && $state[12] == '.' && $state[13] == 'A' && $state[14] == 'A') {
			$new_state = $state;
			$new_state[12] = $new_state[5];
			$new_state[5] = '.';
			$new_state[0] += price($state[5], 7);
			$new_states[] = $new_state;
		}
		// A position 3 (middle down)
		if($state[5] == 'A' && $state[3] == '.' && $state[4] == '.' && $state[11] == '.' && $state[12] == '.' && $state[13] == '.' && $state[14] == 'A') {
			$new_state = $state;
			$new_state[13] = $new_state[5];
			$new_state[5] = '.';
			$new_state[0] += price($state[5], 8);
			$new_states[] = $new_state;
		}
		// A position 4 (down)
		if($state[5] == 'A' && $state[3] == '.' && $state[4] == '.' && $state[11] == '.' && $state[12] == '.' && $state[13] == '.' && $state[14] == '.') {
			$new_state = $state;
			$new_state[14] = $new_state[5];
			$new_state[5] = '.';
			$new_state[0] += price($state[5], 9);
			$new_states[] = $new_state;
		}
		// B position 1 (up)
		if($state[5] == 'B' && $state[4] == '.' && $state[21] == '.' && $state[22] == 'B' && $state[23] == 'B' && $state[24] == 'B') {
			$new_state = $state;
			$new_state[21] = $new_state[5];
			$new_state[5] = '.';
			$new_state[0] += price($state[5], 4);
			$new_states[] = $new_state;
		}
		// B position 2 (middle up)
		if($state[5] == 'B' && $state[4] == '.' && $state[21] == '.' && $state[22] == '.' && $state[23] == 'B' && $state[24] == 'B') {
			$new_state = $state;
			$new_state[22] = $new_state[5];
			$new_state[5] = '.';
			$new_state[0] += price($state[5], 5);
			$new_states[] = $new_state;
		}
		// B position 3 (middle down)
		if($state[5] == 'B' && $state[4] == '.' && $state[21] == '.' && $state[22] == '.' && $state[23] == '.' && $state[24] == 'B') {
			$new_state = $state;
			$new_state[23] = $new_state[5];
			$new_state[5] = '.';
			$new_state[0] += price($state[5], 6);
			$new_states[] = $new_state;
		}
		// B position 4 (down)
		if($state[5] == 'B' && $state[4] == '.' && $state[21] == '.' && $state[22] == '.' && $state[23] == '.' && $state[24] == '.') {
			$new_state = $state;
			$new_state[24] = $new_state[5];
			$new_state[5] = '.';
			$new_state[0] += price($state[5], 7);
			$new_states[] = $new_state;
		}
		// C position 1 (up)
		if($state[5] == 'C' && $state[31] == '.' && $state[32] == 'C' && $state[33] == 'C' && $state[34] == 'C') {
			$new_state = $state;
			$new_state[31] = $new_state[5];
			$new_state[5] = '.';
			$new_state[0] += price($state[5], 2);
			$new_states[] = $new_state;
		}
		// C position 2 (middle up)
		if($state[5] == 'C' && $state[31] == '.' && $state[32] == '.' && $state[33] == 'C' && $state[34] == 'C') {
			$new_state = $state;
			$new_state[32] = $new_state[5];
			$new_state[5] = '.';
			$new_state[0] += price($state[5], 3);
			$new_states[] = $new_state;
		}
		// C position 3 (middle down)
		if($state[5] == 'C' && $state[31] == '.' && $state[32] == '.' && $state[33] == '.' && $state[34] == 'C') {
			$new_state = $state;
			$new_state[33] = $new_state[5];
			$new_state[5] = '.';
			$new_state[0] += price($state[5], 4);
			$new_states[] = $new_state;
		}
		// C position 4 (down)
		if($state[5] == 'C' && $state[31] == '.' && $state[32] == '.' && $state[33] == '.' && $state[34] == '.') {
			$new_state = $state;
			$new_state[34] = $new_state[5];
			$new_state[5] = '.';
			$new_state[0] += price($state[5], 5);
			$new_states[] = $new_state;
		}
		// D position 1 (up)
		if($state[5] == 'D' && $state[41] == '.' && $state[42] == 'D' && $state[43] == 'D' && $state[44] == 'D') {
			$new_state = $state;
			$new_state[41] = $new_state[5];
			$new_state[5] = '.';
			$new_state[0] += price($state[5], 2);
			$new_states[] = $new_state;
		}
		// D position 2 (middle up)
		if($state[5] == 'D' && $state[41] == '.' && $state[42] == '.' && $state[43] == 'D' && $state[44] == 'D') {
			$new_state = $state;
			$new_state[42] = $new_state[5];
			$new_state[5] = '.';
			$new_state[0] += price($state[5], 3);
			$new_states[] = $new_state;
		}
		// D position 3 (middle down)
		if($state[5] == 'D' && $state[41] == '.' && $state[42] == '.' && $state[43] == '.' && $state[44] == 'D') {
			$new_state = $state;
			$new_state[43] = $new_state[5];
			$new_state[5] = '.';
			$new_state[0] += price($state[5], 4);
			$new_states[] = $new_state;
		}
		// D position 4 (down)
		if($state[5] == 'D' && $state[41] == '.' && $state[42] == '.' && $state[43] == '.' && $state[44] == '.') {
			$new_state = $state;
			$new_state[44] = $new_state[5];
			$new_state[5] = '.';
			$new_state[0] += price($state[5], 5);
			$new_states[] = $new_state;
		}
	}
	// hallway position 6
	if($state[6] != '.') {
		// A position 1 (up)
		if($state[6] == 'A' && $state[3] == '.' && $state[4] == '.' && $state[5] == '.' && $state[11] == '.' && $state[12] == 'A' && $state[13] == 'A' && $state[14] == 'A') {
			$new_state = $state;
			$new_state[11] = $new_state[6];
			$new_state[6] = '.';
			$new_state[0] += price($state[6], 8);
			$new_states[] = $new_state;
		}
		// A position 2 (middle up)
		if($state[6] == 'A' && $state[3] == '.' && $state[4] == '.' && $state[5] == '.' && $state[11] == '.' && $state[12] == '.' && $state[13] == 'A' && $state[14] == 'A') {
			$new_state = $state;
			$new_state[12] = $new_state[6];
			$new_state[6] = '.';
			$new_state[0] += price($state[6], 9);
			$new_states[] = $new_state;
		}
		// A position 3 (middle down)
		if($state[6] == 'A' && $state[3] == '.' && $state[4] == '.' && $state[5] == '.' && $state[11] == '.' && $state[12] == '.' && $state[13] == '.' && $state[14] == 'A') {
			$new_state = $state;
			$new_state[13] = $new_state[6];
			$new_state[6] = '.';
			$new_state[0] += price($state[6], 10);
			$new_states[] = $new_state;
		}
		// A position 4 (down)
		if($state[6] == 'A' && $state[3] == '.' && $state[4] == '.' && $state[5] == '.' && $state[11] == '.' && $state[12] == '.' && $state[13] == '.' && $state[14] == '.') {
			$new_state = $state;
			$new_state[14] = $new_state[6];
			$new_state[6] = '.';
			$new_state[0] += price($state[6], 11);
			$new_states[] = $new_state;
		}
		// B position 1 (up)
		if($state[6] == 'B' && $state[4] == '.' && $state[5] == '.' && $state[21] == '.' && $state[22] == 'B' && $state[23] == 'B' && $state[24] == 'B') {
			$new_state = $state;
			$new_state[21] = $new_state[6];
			$new_state[6] = '.';
			$new_state[0] += price($state[6], 6);
			$new_states[] = $new_state;
		}
		// B position 2 (middle up)
		if($state[6] == 'B' && $state[4] == '.' && $state[5] == '.' && $state[21] == '.' && $state[22] == '.' && $state[23] == 'B' && $state[24] == 'B') {
			$new_state = $state;
			$new_state[22] = $new_state[6];
			$new_state[6] = '.';
			$new_state[0] += price($state[6], 7);
			$new_states[] = $new_state;
		}
		// B position 3 (middle down)
		if($state[6] == 'B' && $state[4] == '.' && $state[5] == '.' && $state[21] == '.' && $state[22] == '.' && $state[23] == '.' && $state[24] == 'B') {
			$new_state = $state;
			$new_state[23] = $new_state[6];
			$new_state[6] = '.';
			$new_state[0] += price($state[6], 8);
			$new_states[] = $new_state;
		}
		// B position 4 (down)
		if($state[6] == 'B' && $state[4] == '.' && $state[5] == '.' && $state[21] == '.' && $state[22] == '.' && $state[23] == '.' && $state[24] == '.') {
			$new_state = $state;
			$new_state[24] = $new_state[6];
			$new_state[6] = '.';
			$new_state[0] += price($state[6], 9);
			$new_states[] = $new_state;
		}
		// C position 1 (up)
		if($state[6] == 'C' && $state[5] == '.' && $state[31] == '.' && $state[32] == 'C' && $state[33] == 'C' && $state[34] == 'C') {
			$new_state = $state;
			$new_state[31] = $new_state[6];
			$new_state[6] = '.';
			$new_state[0] += price($state[6], 4);
			$new_states[] = $new_state;
		}
		// C position 2 (middle up)
		if($state[6] == 'C' && $state[5] == '.' && $state[31] == '.' && $state[32] == '.' && $state[33] == 'C' && $state[34] == 'C') {
			$new_state = $state;
			$new_state[32] = $new_state[6];
			$new_state[6] = '.';
			$new_state[0] += price($state[6], 5);
			$new_states[] = $new_state;
		}
		// C position 3 (middle down)
		if($state[6] == 'C' && $state[5] == '.' && $state[31] == '.' && $state[32] == '.' && $state[33] == '.' && $state[34] == 'C') {
			$new_state = $state;
			$new_state[33] = $new_state[6];
			$new_state[6] = '.';
			$new_state[0] += price($state[6], 6);
			$new_states[] = $new_state;
		}
		// C position 4 (down)
		if($state[6] == 'C' && $state[5] == '.' && $state[31] == '.' && $state[32] == '.' && $state[33] == '.' && $state[34] == '.') {
			$new_state = $state;
			$new_state[34] = $new_state[6];
			$new_state[6] = '.';
			$new_state[0] += price($state[6], 7);
			$new_states[] = $new_state;
		}
		// D position 1 (up)
		if($state[6] == 'D' && $state[41] == '.' && $state[42] == 'D' && $state[43] == 'D' && $state[44] == 'D') {
			$new_state = $state;
			$new_state[41] = $new_state[6];
			$new_state[6] = '.';
			$new_state[0] += price($state[6], 2);
			$new_states[] = $new_state;
		}
		// D position 2 (middle up)
		if($state[6] == 'D' && $state[41] == '.' && $state[42] == '.' && $state[43] == 'D' && $state[44] == 'D') {
			$new_state = $state;
			$new_state[42] = $new_state[6];
			$new_state[6] = '.';
			$new_state[0] += price($state[6], 3);
			$new_states[] = $new_state;
		}
		// D position 3 (middle down)
		if($state[6] == 'D' && $state[41] == '.' && $state[42] == '.' && $state[43] == '.' && $state[44] == 'D') {
			$new_state = $state;
			$new_state[43] = $new_state[6];
			$new_state[6] = '.';
			$new_state[0] += price($state[6], 4);
			$new_states[] = $new_state;
		}
		// D position 4 (down)
		if($state[6] == 'D' && $state[41] == '.' && $state[42] == '.' && $state[43] == '.' && $state[44] == '.') {
			$new_state = $state;
			$new_state[44] = $new_state[6];
			$new_state[6] = '.';
			$new_state[0] += price($state[6], 5);
			$new_states[] = $new_state;
		}
	}
	// hallway position 7
	if($state[7] != '.' && $state[6] == '.') {
		// A position 1 (up)
		if($state[7] == 'A' && $state[3] == '.' && $state[4] == '.' && $state[5] == '.' && $state[11] == '.' && $state[12] == 'A' && $state[13] == 'A' && $state[14] == 'A') {
			$new_state = $state;
			$new_state[11] = $new_state[7];
			$new_state[7] = '.';
			$new_state[0] += price($state[7], 9);
			$new_states[] = $new_state;
		}
		// A position 2 (middle up)
		if($state[7] == 'A' && $state[3] == '.' && $state[4] == '.' && $state[5] == '.' && $state[11] == '.' && $state[12] == '.' && $state[13] == 'A' && $state[14] == 'A') {
			$new_state = $state;
			$new_state[12] = $new_state[7];
			$new_state[7] = '.';
			$new_state[0] += price($state[7], 10);
			$new_states[] = $new_state;
		}
		// A position 3 (middle down)
		if($state[7] == 'A' && $state[3] == '.' && $state[4] == '.' && $state[5] == '.' && $state[11] == '.' && $state[12] == '.' && $state[13] == '.' && $state[14] == 'A') {
			$new_state = $state;
			$new_state[13] = $new_state[7];
			$new_state[7] = '.';
			$new_state[0] += price($state[7], 11);
			$new_states[] = $new_state;
		}
		// A position 4 (down)
		if($state[7] == 'A' && $state[3] == '.' && $state[4] == '.' && $state[5] == '.' && $state[11] == '.' && $state[12] == '.' && $state[13] == '.' && $state[14] == '.') {
			$new_state = $state;
			$new_state[14] = $new_state[7];
			$new_state[7] = '.';
			$new_state[0] += price($state[7], 12);
			$new_states[] = $new_state;
		}
		// B position 1 (up)
		if($state[7] == 'B' && $state[4] == '.' && $state[5] == '.' && $state[21] == '.' && $state[22] == 'B' && $state[23] == 'B' && $state[24] == 'B') {
			$new_state = $state;
			$new_state[21] = $new_state[7];
			$new_state[7] = '.';
			$new_state[0] += price($state[7], 7);
			$new_states[] = $new_state;
		}
		// B position 2 (middle up)
		if($state[7] == 'B' && $state[4] == '.' && $state[5] == '.' && $state[21] == '.' && $state[22] == '.' && $state[23] == 'B' && $state[24] == 'B') {
			$new_state = $state;
			$new_state[22] = $new_state[7];
			$new_state[7] = '.';
			$new_state[0] += price($state[7], 8);
			$new_states[] = $new_state;
		}
		// B position 3 (middle down)
		if($state[7] == 'B' && $state[4] == '.' && $state[5] == '.' && $state[21] == '.' && $state[22] == '.' && $state[23] == '.' && $state[24] == 'B') {
			$new_state = $state;
			$new_state[23] = $new_state[7];
			$new_state[7] = '.';
			$new_state[0] += price($state[7], 9);
			$new_states[] = $new_state;
		}
		// B position 4 (down)
		if($state[7] == 'B' && $state[4] == '.' && $state[5] == '.' && $state[21] == '.' && $state[22] == '.' && $state[23] == '.' && $state[24] == '.') {
			$new_state = $state;
			$new_state[24] = $new_state[7];
			$new_state[7] = '.';
			$new_state[0] += price($state[7], 10);
			$new_states[] = $new_state;
		}
		// C position 1 (up)
		if($state[7] == 'C' && $state[5] == '.' && $state[31] == '.' && $state[32] == 'C' && $state[33] == 'C' && $state[34] == 'C') {
			$new_state = $state;
			$new_state[31] = $new_state[7];
			$new_state[7] = '.';
			$new_state[0] += price($state[7], 5);
			$new_states[] = $new_state;
		}
		// C position 2 (middle up)
		if($state[7] == 'C' && $state[5] == '.' && $state[31] == '.' && $state[32] == '.' && $state[33] == 'C' && $state[34] == 'C') {
			$new_state = $state;
			$new_state[32] = $new_state[7];
			$new_state[7] = '.';
			$new_state[0] += price($state[7], 6);
			$new_states[] = $new_state;
		}
		// C position 3 (middle down)
		if($state[7] == 'C' && $state[5] == '.' && $state[31] == '.' && $state[32] == '.' && $state[33] == '.' && $state[34] == 'C') {
			$new_state = $state;
			$new_state[33] = $new_state[7];
			$new_state[7] = '.';
			$new_state[0] += price($state[7], 7);
			$new_states[] = $new_state;
		}
		// C position 4 (down)
		if($state[7] == 'C' && $state[5] == '.' && $state[31] == '.' && $state[32] == '.' && $state[33] == '.' && $state[34] == '.') {
			$new_state = $state;
			$new_state[34] = $new_state[7];
			$new_state[7] = '.';
			$new_state[0] += price($state[7], 8);
			$new_states[] = $new_state;
		}
		// D position 1 (up)
		if($state[7] == 'D' && $state[41] == '.' && $state[42] == 'D' && $state[43] == 'D' && $state[44] == 'D') {
			$new_state = $state;
			$new_state[41] = $new_state[7];
			$new_state[7] = '.';
			$new_state[0] += price($state[7], 3);
			$new_states[] = $new_state;
		}
		// D position 2 (middle up)
		if($state[7] == 'D' && $state[41] == '.' && $state[42] == '.' && $state[43] == 'D' && $state[44] == 'D') {
			$new_state = $state;
			$new_state[42] = $new_state[7];
			$new_state[7] = '.';
			$new_state[0] += price($state[7], 4);
			$new_states[] = $new_state;
		}
		// D position 3 (middle down)
		if($state[7] == 'D' && $state[41] == '.' && $state[42] == '.' && $state[43] == '.' && $state[44] == 'D') {
			$new_state = $state;
			$new_state[43] = $new_state[7];
			$new_state[7] = '.';
			$new_state[0] += price($state[7], 5);
			$new_states[] = $new_state;
		}
		// D position 4 (down)
		if($state[7] == 'D' && $state[41] == '.' && $state[42] == '.' && $state[43] == '.' && $state[44] == '.') {
			$new_state = $state;
			$new_state[44] = $new_state[7];
			$new_state[7] = '.';
			$new_state[0] += price($state[7], 6);
			$new_states[] = $new_state;
		}
	}
	return $new_states;
}

function state_to_key($state) {
	return $state[1].'.'.$state[2].'.'.$state[3].'.'.$state[4].'.'.$state[5].'.'.$state[6].'.'.$state[7].'.'.$state[11].'.'.$state[21].'.'.$state[31].'.'.$state[41].'.'.$state[12].'.'.$state[22].'.'.$state[32].'.'.$state[42];
}

function state_to_key_2($state) {
	return $state[1].'.'.$state[2].'.'.$state[3].'.'.$state[4].'.'.$state[5].'.'.$state[6].'.'.$state[7].'.'.$state[11].'.'.$state[21].'.'.$state[31].'.'.$state[41].'.'.$state[12].'.'.$state[22].'.'.$state[32].'.'.$state[42].'.'.$state[13].'.'.$state[23].'.'.$state[33].'.'.$state[43].'.'.$state[14].'.'.$state[24].'.'.$state[34].'.'.$state[44];
}

function price($char, $spaces) {
	if($char == 'A')
		return $spaces;
	if($char == 'B')
		return $spaces * 10;
	if($char == 'C')
		return $spaces * 100;
	if($char == 'D')
		return $spaces * 1000;
}

function nice_print($state) {
	echo '#############'."\n";
	echo '#'.$state[1].$state[2].'.'.$state[3].'.'.$state[4].'.'.$state[5].'.'.$state[6].$state[7].'#'."\n";
	echo '###'.$state[11].'#'.$state[21].'#'.$state[31].'#'.$state[41].'###'."\n";
  	echo '  #'.$state[12].'#'.$state[22].'#'.$state[32].'#'.$state[42].'#'."\n";
	echo '  #########'."\n";
	echo 'score '.$state[0]."\n";
}

function nice_print_2($state) {
	echo '#############'."\n";
	echo '#'.$state[1].$state[2].'.'.$state[3].'.'.$state[4].'.'.$state[5].'.'.$state[6].$state[7].'#'."\n";
	echo '###'.$state[11].'#'.$state[21].'#'.$state[31].'#'.$state[41].'###'."\n";
  	echo '  #'.$state[12].'#'.$state[22].'#'.$state[32].'#'.$state[42].'#'."\n";
  	echo '  #'.$state[13].'#'.$state[23].'#'.$state[33].'#'.$state[43].'#'."\n";
  	echo '  #'.$state[14].'#'.$state[24].'#'.$state[34].'#'.$state[44].'#'."\n";
	echo '  #########'."\n";
	echo 'score '.$state[0]."\n";
}
?>