<?

$lines = file('input.txt', FILE_IGNORE_NEW_LINES);

$tree = array();
foreach($lines as $line)
	$tree[] = str_split($line);

// part 1
$num = 0;
for($i = 0; $i < count($tree); $i++)
	for($j = 0; $j < count($tree[$i]); $j++)
	{
		if($i == 0 || $i == count($tree)-1 || $j == 0 || $j == count($tree[$i])-1) {
			$num++;
		} else {
			$vis = true;
			for($a = 0; $a < $i; $a++)
				if($tree[$a][$j] >= $tree[$i][$j])
					$vis = false;
			if($vis) {
				$num++;
				continue;
			}

			$vis = true;
			for($a = $i+1; $a < count($tree); $a++)
				if($tree[$a][$j] >= $tree[$i][$j])
					$vis = false;
			if($vis) {
				$num++;
				continue;
			}

			$vis = true;
			for($a = 0; $a < $j; $a++)
				if($tree[$i][$a] >= $tree[$i][$j])
					$vis = false;
			if($vis) {
				$num++;
				continue;
			}

			$vis = true;
			for($a = $j+1; $a < count($tree[$i]); $a++)
				if($tree[$i][$a] >= $tree[$i][$j])
					$vis = false;
			if($vis) {
				$num++;
				continue;
			}
		}
	}

echo $num."\n";

// part 2
$max = 0;
for($i = 0; $i < count($tree); $i++)
	for($j = 0; $j < count($tree[$i]); $j++) {
		$s1 = $s2 = $s3 = $s4 = 0;
		for($a = $i - 1; $a >= 0; $a--) {
			$s1++;
			if($tree[$a][$j] >= $tree[$i][$j])
				break;
		}

		for($a = $i + 1; $a < count($tree); $a++) {
			$s2++;
			if($tree[$a][$j] >= $tree[$i][$j])
				break;
		}

		for($a = $j - 1; $a >= 0; $a--) {
			$s3++;
			if($tree[$i][$a] >= $tree[$i][$j])
				break;
		}

		for($a = $j + 1; $a < count($tree[$i]); $a++) {
			$s4++;
			if($tree[$i][$a] >= $tree[$i][$j])
				break;
		}

		$max = max($max, $s1 * $s2 * $s3 * $s4);
	}

echo $max."\n";

?>