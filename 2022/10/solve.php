<?

$lines = file('input.txt', FILE_IGNORE_NEW_LINES);

// part 1
$cyc = 1;
$tot = 1;
$score = 0;
$seek = 20;

foreach($lines as $line) {
	list($ord, $val) = sscanf($line, "%s %d");
	if($ord == 'noop')
		$cyc++;
	if($ord == 'addx')
		$cyc += 2;
	if($cyc > $seek) {
		$score += $seek * $tot;
		$seek += 40;
	}
	if($ord == 'addx')
		$tot += $val;
}

echo $score."\n";

// part 2
$cyc = 0;
$tot = 1;
$echo = '';

foreach($lines as $line) {
	list($ord, $val) = sscanf($line, "%s %d");

	if($cyc % 40 >= $tot - 1 && $cyc %40 <= $tot + 1)
		$echo .= '0';
	else
		$echo .= ' ';
	$cyc++;

	if($ord == 'addx') {
		if($cyc % 40 >= $tot - 1 && $cyc % 40 <= $tot + 1)
			$echo .= '0';
		else
			$echo .= ' ';
		$cyc++;
		$tot += $val;
	}
}

echo implode("\n", str_split($echo, 40))."\n";

?>