<?

$lines = file('input.txt', FILE_IGNORE_NEW_LINES);

// part 1
$positions = explode(',', $lines[0]);
$crab_by_pos = array_fill(min($positions), max($positions) - min($positions) + 1, 0);
foreach($positions as $pos)
	$crab_by_pos[$pos]++;

$best_score = PHP_INT_MAX ;
$best_position = -1;
foreach($crab_by_pos as $guess_position => $j) {
	$score = 0;
	foreach($crab_by_pos as $cur_position => $crabs)
		$score += abs($guess_position - $cur_position) * $crabs;
	if($score < $best_score) {
		$best_score = $score;
		$best_position = $guess_position;
	}
}

echo $best_score."\n";

// part 2
$best_score = PHP_INT_MAX ;
$best_position = -1;
foreach($crab_by_pos as $guess_position => $j) {
	$score = 0;
	foreach($crab_by_pos as $cur_position => $crabs) {
		$fuel = abs($guess_position - $cur_position);
		$fuel = ($fuel * ($fuel + 1)) / 2;
		$score += $fuel * $crabs;
	}
	if($score < $best_score) {
		$best_score = $score;
		$best_position = $guess_position;
	}
}

echo $best_score."\n";

?>