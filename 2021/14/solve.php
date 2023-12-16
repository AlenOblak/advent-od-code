<?

$lines = file('input.txt', FILE_IGNORE_NEW_LINES);

$template = $lines[0];
for($i = 2; $i < count($lines); $i++) {
	list($a, $b) = sscanf($lines[$i], "%s -> %s");
	$pairs[$a] = $b;
}

// part 1
result($template, $pairs, 10);

// part 2
result($template, $pairs, 40);

function result($template, $pairs, $max_steps) {
	$elements = array();
	$first_element = $template[0].$template[1];
	$last_element = '';
	for($i = 0; $i < strlen($template)-1; $i++) {
		$elements[$template[$i].$template[$i+1]]++;
		$last_element = $template[$i].$template[$i+1];
	}

	$step = 0;
	while($step++ < $max_steps) {
		$new_elements = array();
		foreach($elements as $e => $el) {
			$new_elements[$e[0].$pairs[$e[0].$e[1]]] += $el;
			$new_elements[$pairs[$e[0].$e[1]].$e[1]] += $el;
		}
		$first_element = $first_element[0].$pairs[$first_element[0].$first_element[1]];
		$last_element = $pairs[$last_element[0].$last_element[1]].$last_element[1];
		$elements = $new_elements;
	}

	foreach($elements as $e => $el) {
		$keys[$e[0]] += $el;
		$keys[$e[1]] += $el;
	}
	$keys[$first_element[0]]++;
	$keys[$last_element[1]]++;

	$min = 0;
	$max = 0;
	foreach($keys as $count)  {
		$count /= 2;
		if($min == 0 || $min > $count)
			$min = $count;
		if($max == 0 || $max < $count)
			$max = $count;
	}
	echo ($max - $min)."\n";
}
?>