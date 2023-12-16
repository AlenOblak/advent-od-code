<?

$lines = file('input.txt', FILE_IGNORE_NEW_LINES);

// part 1
$score = 0;

foreach($lines as $line) {
	$first = substr($line, 0, strlen($line) / 2);
	$second = substr($line, strlen($line) / 2);

	$cross = array_intersect(str_split($first), str_split($second));
	$cross = array_pop($cross);
	$score += char_score($cross[0]);
}

echo $score."\n";

function char_score($char) {
	if(ord($char) < 96)
		return ord($char) - 64 + 26;
	else
		return ord($char) - 96;
}

// part 2
$first = $second = $third = '';
$score = 0;
foreach($lines as $line) {
	if($first == '')
		$first = $line;
	elseif($second == '')
		$second = $line;
	elseif($third == '') {
		$third = $line;

		$cross = array_intersect(str_split($first), str_split($second), str_split($third));
		$cross = array_pop($cross);
		$score += char_score($cross);

		$first = $second = $third = '';
	}
}

echo $score."\n";

?>