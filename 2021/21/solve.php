<?

$lines = file('input.txt', FILE_IGNORE_NEW_LINES);

// part 1
$pos[0] = substr($lines[0], 28);
$pos[1] = substr($lines[1], 28);
$score[0] = 0;
$score[1] = 0;
$player = 0;
$dice = 0;
$roll = 0;

while($score[0] < 1000 && $score[1] < 1000) {
	$pos[$player] += roll() + roll() + roll();
	while($pos[$player] > 10)
		$pos[$player] -= 10;
	$score[$player] += $pos[$player];
	$player = 1 - $player;
}

echo min($score[0], $score[1])*$roll."\n";

function roll() {
	global $dice;
	global $roll;
	$dice++;
	$roll++;
	if($dice > 100)
		$dice = 1;
	return $dice;
}

// part 2
for($i = 1; $i <4; $i++)
	for($j = 1; $j <4; $j++)
		for($k = 1; $k <4; $k++)
			$outcome[$i+$j+$k]++;

// pos A, pos B, score A, score B, player turn, count
$positions[] = array('posA' => substr($lines[0], 28), 'posB' => substr($lines[1], 28), 'scoreA' => 0, 'scoreB' => 0, 'player' => 'A', 'count' => 1);
$winA = 0;
$winB = 0;
while(count($positions) > 0) {
	$min_score = 99;
	$min_key = 0;
	foreach($positions as $key => $position)
		if(($position['scoreA'] + $position['scoreB']) < $min_score) {
			$min_score = ($position['scoreA'] + $position['scoreB']);
			$min_key = $key;
		}
	$pos = $positions[$min_key];
	unset($positions[$min_key]);
	foreach($outcome as $dice => $comb) {
		$new_position = next_move($pos, $dice, $comb);
		if($new_position != null) {
			$found = false;
			foreach($positions as $key => $position) {
				if($position['posA'] == $new_position['posA'] && 
				   $position['posB'] == $new_position['posB'] && 
					$position['scoreA'] == $new_position['scoreA'] && 
					$position['scoreB'] == $new_position['scoreB'] && 
					$position['player'] == $new_position['player']) {
					$positions[$key]['count'] += $new_position['count'];
					$found = true;
					break;
				}
			}
			if(!$found)
				$positions[] = $new_position;
		}
	}
}

echo max($winA, $winB)."\n";

function next_move($pos, $dice, $comb) {
	global $winA, $winB;
	$pos['pos'.$pos['player']] += $dice;
	while($pos['pos'.$pos['player']] > 10)
		$pos['pos'.$pos['player']] -= 10;
	$pos['score'.$pos['player']] += $pos['pos'.$pos['player']];

	if($pos['player'] == 'A')
		$pos['player'] = 'B';
	else
		$pos['player'] = 'A';

	$pos['count'] *= $comb;
	if($pos['scoreA'] >= 21) {
		$winA += $pos['count'];
		return null;
	}
	if($pos['scoreB'] >= 21) {
		$winB += $pos['count'];
		return null;
	}
	return $pos;
}

?>