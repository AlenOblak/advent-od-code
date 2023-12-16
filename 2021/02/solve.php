<?

$lines = file('input.txt');

// part 1
$horizontal = 0;
$vertical = 0;
for ($i = 0; $i < count($lines); $i++) {
	list($direction, $length) = sscanf($lines[$i], "%s %d");
	if($direction == 'forward')
		$horizontal += $length;
	if($direction == 'down')
		$vertical += $length;
	if($direction == 'up')
		$vertical -= $length;
}
echo ($horizontal * $vertical)."\n";

// part 2
$horizontal = 0;
$vertical = 0;
$aim = 0;
for ($i = 0; $i < count($lines); $i++) {
	list($direction, $length) = sscanf($lines[$i], "%s %d");
	if($direction == 'forward') {
		$horizontal += $length;
		$vertical += ($aim * $length);
	}
	if($direction == 'down')
		$aim += $length;
	if($direction == 'up')
		$aim -= $length;

}
echo ($horizontal * $vertical)."\n";

?>