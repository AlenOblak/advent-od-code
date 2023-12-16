<?

$lines = file('input.txt', FILE_IGNORE_NEW_LINES);

$line = $lines[0];

// part 1
$length = 4;
for($i = 1; $i < strlen($line); $i++) {
	if(count(array_unique(str_split(substr($line, $i, $length)))) == $length) {
		echo ($i + $length)."\n";
		break;
	}
}

// part 2
$length = 14;
for($i = 1; $i < strlen($line); $i++) {
	if(count(array_unique(str_split(substr($line, $i, $length)))) == $length) {
		echo ($i + $length)."\n";
		break;
	}
}

?>