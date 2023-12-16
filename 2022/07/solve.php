<?

$lines = file('input.txt', FILE_IGNORE_NEW_LINES);

$dir = array();

$curent_dir = array();
foreach($lines as $line) {
	$command = explode(' ', $line);
	if($command[1] == 'cd') {
		if($command[2] == '..') {
			array_pop($curent_dir);
		} else {
			array_push($curent_dir, $command[2]);
			$dir[implode('-', $curent_dir)] = 0;
		}
	} elseif($command[1] == 'ls') {
	} elseif($command[0] == 'dir') {
	} else {
		list($s, $f) = sscanf($line, "%d %s");
		for($i = 1; $i <= count($curent_dir); $i++)
			$dir[implode('-', array_slice($curent_dir, 0, $i))] += $s;
	}
}

$sum = 0;
$free = 30000000 - (70000000 - $dir['/']);
$min = PHP_INT_MAX;
foreach($dir as $d) {
	if($d <= 100000)
		$sum += $d;
	if($d > $free)
		$min = min($min, $d);
}

echo $sum."\n";
echo $min."\n";

?>