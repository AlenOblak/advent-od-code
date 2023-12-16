<?

$lines = file('input.txt', FILE_IGNORE_NEW_LINES);

// part 1
$elves = array();
$cal = 0;

foreach($lines as $line) {
	if($line == '') {
		$elves[] = $cal;
		$cal = 0;
	} else
		$cal += $line;
}
$elves[] = $cal;

echo max($elves)."\n";

// part 2
sort($elves);
echo $elves[count($elves) - 1] + $elves[count($elves) - 2] + $elves[count($elves) - 3]."\n";

?>