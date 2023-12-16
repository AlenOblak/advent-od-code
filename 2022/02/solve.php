<?

$lines = file('input.txt', FILE_IGNORE_NEW_LINES);

// part 1

$score = 0;

foreach($lines as $line) {
	$opp = $line[0];
	$me = $line[2];

	$score += score($opp, $me);
}

function score($opp, $me) {
	$score = 0;

	if($me == 'X') // rock
		$score += 1;
	elseif($me == 'Y') // paper
		$score += 2;
	else // scissors
		$score += 3;
	
	if($opp == 'A') { // rock
		if($me == 'X') // rock
			$score += 3;
		elseif($me == 'Y') // paper
			$score += 6;
	} elseif($opp == 'B') { // paper
		if($me == 'Y') // paper
			$score += 3;
		elseif($me == 'Z') // scissors
			$score += 6;
	} elseif($opp == 'C') { // scissors
		if($me == 'X') // rock
			$score += 6;
		elseif($me == 'Z') // scissors
			$score += 3;
	}

	return $score;
}

echo $score."\n";

// part 2

$score = 0;

foreach($lines as $line) {
	$opp = $line[0];
	$outcome = $line[2];
	
	if($outcome == 'X') { // lose
		if($opp == 'A') // rock
			$me = 'Z';
		elseif($opp == 'B') // paper
			$me = 'X';
		elseif($opp == 'C') // scissors
			$me = 'Y';
	} elseif($outcome == 'Y') { // draw
		if($opp == 'A') // rock
			$me = 'X';
		elseif($opp == 'B') // paper
			$me = 'Y';
		elseif($opp == 'C') // scissors
			$me = 'Z';
	} elseif($outcome == 'Z') { // win
		if($opp == 'A') // rock
			$me = 'Y';
		elseif($opp == 'B') // paper
			$me = 'Z';
		elseif($opp == 'C') // scissors
			$me = 'X';
	}

	$score += score($opp, $me);
}

echo $score."\n";

?>