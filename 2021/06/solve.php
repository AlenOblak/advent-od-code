<?

$lines = file('input.txt', FILE_IGNORE_NEW_LINES);

// part 1
$fishes = explode(',', $lines[0]);

$fish_by_day = array(0, 0, 0, 0, 0, 0, 0, 0, 0);
foreach($fishes as $fish)
	$fish_by_day[$fish]++;

for($day = 1; $day <= 80; $day++) {
	$fish_new[0] = $fish_by_day[1];
	$fish_new[1] = $fish_by_day[2];
	$fish_new[2] = $fish_by_day[3];
	$fish_new[3] = $fish_by_day[4];
	$fish_new[4] = $fish_by_day[5];
	$fish_new[5] = $fish_by_day[6];
	$fish_new[6] = $fish_by_day[7] + $fish_by_day[0];
	$fish_new[7] = $fish_by_day[8];
	$fish_new[8] = $fish_by_day[0];
	$fish_by_day = $fish_new;
}

echo array_sum($fish_by_day)."\n";

// part 2
for($day = 81; $day <= 256; $day++) {
	$fish_new[0] = $fish_by_day[1];
	$fish_new[1] = $fish_by_day[2];
	$fish_new[2] = $fish_by_day[3];
	$fish_new[3] = $fish_by_day[4];
	$fish_new[4] = $fish_by_day[5];
	$fish_new[5] = $fish_by_day[6];
	$fish_new[6] = $fish_by_day[7] + $fish_by_day[0];
	$fish_new[7] = $fish_by_day[8];
	$fish_new[8] = $fish_by_day[0];
	$fish_by_day = $fish_new;
}

echo array_sum($fish_by_day)."\n";

?>