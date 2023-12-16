<?

$lines = file('input.txt', FILE_IGNORE_NEW_LINES);

$i = 0;
$pos_0 = 0;
foreach($lines as $line) {
	if($line == 0)
		$pos_0 = $i;
	$file[] = array($line, $i++);
}

$pos = $file;

// part 1
$file = mix_numbers($file, $pos);
echo file_value($file, $pos_0)."\n";

// part 2
$file = $pos;
for($i = 0; $i < count($file); $i++)
	$file[$i][0] *= 811589153;
$pos = $file;

for($i = 0; $i < 10; $i++)
	$file = mix_numbers($file, $pos);

echo file_value($file, $pos_0)."\n";

// mix file numbers
function mix_numbers($file, $pos) {
	foreach($pos as $a) {
		$from = array_search($a, $file);
		$to = (($from + $a[0]) % (count($file)-1));
		if($to <= 0)
			$to += (count($file)-1);
		if($from < $to) {
			for($i = $from; $i < $to; $i++)
				$file[$i] = $file[$i+1];
			$file[$to] = $a;
		} else {
			for($i = $from; $i > $to; $i--)
				$file[$i] = $file[$i-1];
			$file[$to] = $a;
		}
	}
	return $file;
}

// calculate file value
function file_value($file, $pos) {
	$from = $pos;
	$from = array_search(array(0, $pos), $file);
	$v1 = ($from + 1000);
	while($v1 >= count($file))
		$v1 -= count($file);
	$v2 = ($from + 2000);
	while($v2 >= count($file))
		$v2 -= count($file);
	$v3 = ($from + 3000);
	while($v3 >= count($file))
		$v3 -= count($file);

	$v1 = $file[$v1][0];
	$v2 = $file[$v2][0];
	$v3 = $file[$v3][0];

	return $v1+$v2+$v3;
}

?>