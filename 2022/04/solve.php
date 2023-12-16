<?

$lines = file('input.txt', FILE_IGNORE_NEW_LINES);

$num1 = 0;
$num2 = 0;

foreach($lines as $line) {
	list($a, $b, $c, $d) = sscanf($line, "%d-%d,%d-%d");
	if(($a <= $c && $b >= $d) || ($c <= $a && $d >= $b))
		$num1++;
	if(!($b < $c || $d < $a))
		$num2++;
}

echo $num1."\n";
echo $num2."\n";

?>