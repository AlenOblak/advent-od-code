<?

$lines = file('input.txt', FILE_IGNORE_NEW_LINES);

// part 1
foreach($lines as $line) {
	$stack = array();
	$corrupted = false;
	foreach(str_split($line) as $char) {
		if(in_array($char, array('<', '[', '(', '{'))) {
			array_push($stack, $char);
		} else {
			$start = array_pop($stack);
			if($char == '>' && $start != '<') {
				$corrupted = true;
				$score += 25137;
				break;
			}
			if($char == ')' && $start != '(') {
				$corrupted = true;
				$score += 3;
				break;
			}
			if($char == ']' && $start != '[') {
				$corrupted = true;
				$score += 57;
				break;
			}
			if($char == '}' && $start != '{') {
				$corrupted = true;
				$score += 1197;
				break;
			}
		}
	}
	if(!$corrupted)
		$incomplete[] = $line;
}
echo $score."\n";

// part 2
foreach($incomplete as $line) {
	$stack = array();
	foreach(str_split($line) as $char) {
		if(in_array($char, array('<', '[', '(', '{'))) {
			array_push($stack, $char);
		} else {
			array_pop($stack);
		}
	}
	$score = 0;
	while($char = array_pop($stack)) {
		$score *= 5;
		if($char == '(')
			$score += 1;
		if($char == '[')
			$score += 2;
		if($char == '{')
			$score += 3;
		if($char == '<')
			$score += 4;
	}
	$scores[] = $score;
}
sort($scores);
echo $scores[(count($scores)-1)/2]."\n";

?>