<?

$lines = file('input.txt', FILE_IGNORE_NEW_LINES);

$monkey = array();
$num = 0;
$div = 1;
foreach($lines as $line) {
	$words = explode(' ', trim($line));
	if($line == '') {
		$num++;
	} elseif ($words[0] == 'Monkey') {
		$monkey[$num][6] = 0;
	} elseif ($words[0] == 'Starting') {
		$monkey[$num][0] = explode(', ', substr($line, 18));
	} elseif ($words[0] == 'Operation:') {
		$monkey[$num][1] = $words[4];
		$monkey[$num][2] = $words[5];
	} elseif ($words[0] == 'Test:') {
		$monkey[$num][3] = $words[3];
		$div *= $words[3];
	} elseif ($words[1] == 'true:') {
		$monkey[$num][4] = $words[5];
	} elseif ($words[1] == 'false:') {
		$monkey[$num][5] = $words[5];
	} 
}
$monkey_0 = $monkey;

// part 1
for($i = 1; $i <= 20; $i++) {
	for($m = 0; $m < count($monkey); $m++) {
		foreach($monkey[$m][0] as $item) {
			$monkey[$m][6]++;
			if($monkey[$m][1] == '*') {
				if($monkey[$m][2] == 'old')
					$level = $item * $item;
				else
					$level = $item * $monkey[$m][2];
			} elseif($monkey[$m][1] == '+') {
				if($monkey[$m][2] == 'old')
					$level = $item + $item;
				else
					$level = $item + $monkey[$m][2];
			}
			$level = floor($level / 3);
			$rem = $level % $monkey[$m][3];
			if($rem == 0)
				array_push($monkey[$monkey[$m][4]][0], $level);
			else
				array_push($monkey[$monkey[$m][5]][0], $level);
		}
		$monkey[$m][0] = array();
	}
}
$max = array();
foreach($monkey as $m)
	$max[] = $m[6];
rsort($max);
echo $max[0]*$max[1]."\n";

// part 2
$monkey = $monkey_0;
for($i = 1; $i <= 10000; $i++) {
	for($m = 0; $m < count($monkey); $m++) {
		foreach($monkey[$m][0] as $item) {
			$monkey[$m][6]++;
			if($monkey[$m][1] == '*') {
				if($monkey[$m][2] == 'old')
					$level = $item * $item;
				else
					$level = $item * $monkey[$m][2];
			} elseif($monkey[$m][1] == '+') {
				if($monkey[$m][2] == 'old')
					$level = $item + $item;
				else
					$level = $item + $monkey[$m][2];
			}
			$rem = $level % $monkey[$m][3];
			$level = $level % $div;
			if($rem == 0)
				array_push($monkey[$monkey[$m][4]][0], $level);
			else
				array_push($monkey[$monkey[$m][5]][0], $level);
		}
		$monkey[$m][0] = array();
	}
}
$max = array();
foreach($monkey as $m)
	$max[] = $m[6];
rsort($max);
echo $max[0]*$max[1]."\n";

?>