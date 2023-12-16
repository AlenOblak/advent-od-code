<?

$lines = file('input.txt', FILE_IGNORE_NEW_LINES);

// part 1
foreach($lines as $line) {
	$temp = explode('|', $line);
	$entry = array(explode(' ', trim($temp[0])), explode(' ', trim($temp[1])));
	$entries[] = $entry;
}
foreach($entries as $entry) {
	foreach($entry[1] as $signal) {
		if(strlen($signal) == 2 || strlen($signal) == 3 || strlen($signal) == 4 || strlen($signal) == 7)
			$count++;
	}
}
echo $count."\n";

// part 2
foreach($entries as $entry) {
	// determine signal for keys 1, 4, 7, 8
	foreach($entry[0] as $signal) {
		if(strlen($signal) == 2)
			$sig_1 = sort_signal($signal);
		if(strlen($signal) == 3)
			$sig_7 = sort_signal($signal);
		if(strlen($signal) == 4)
			$sig_4 = sort_signal($signal);
		if(strlen($signal) == 7)
			$sig_8 = sort_signal($signal);
	}
	$pos_a = str_replace(str_split($sig_1), '', $sig_7);
	// determine signal for key 2, 5, 6
	foreach(str_split($sig_1) as $key) {
		$count = 0;
		foreach($entry[0] as $signal) {
			if(strpos($signal, $key) === false) {
				$count++;
				$temp_sig2 = $signal;
				if(strlen($signal) == 5)
					$temp_sig5 = $signal;
				if(strlen($signal) == 6)
					$temp_sig6 = $signal;
			}
		}
		if($count == 1)
			$sig_2 = sort_signal($temp_sig2);
		if($count == 2) {
			$sig_5 = sort_signal($temp_sig5);
			$sig_6 = sort_signal($temp_sig6);
		}
	}
	// determine signal for key 3
	foreach($entry[0] as $signal) {
		if(strlen($signal) == 5 && sort_signal($signal) != $sig_2 && sort_signal($signal) != $sig_5)
			$sig_3 = sort_signal($signal);
	}
	// determine signal for key 9 and 0
	foreach($entry[0] as $signal) {
		if(strlen($signal) == 6 && sort_signal($signal) != $sig_6 ) {
			if(count(array_diff(str_split($signal), str_split($sig_3))) == 1)
				$sig_9 = sort_signal($signal);
			else
				$sig_0 = sort_signal($signal);
		}
	}

	// determine output
	$real_number = '';
	foreach($entry[1] as $number) {
		switch (sort_signal($number)) {
			case $sig_0:
				$real_number .= '0';
				break;
			case $sig_1:
				$real_number .= '1';
				break;
			case $sig_2:
				$real_number .= '2';
				break;
			case $sig_3:
				$real_number .= '3';
				break;
			case $sig_4:
				$real_number .= '4';
				break;
			case $sig_5:
				$real_number .= '5';
				break;
			case $sig_6:
				$real_number .= '6';
				break;
			case $sig_7:
				$real_number .= '7';
				break;
			case $sig_8:
				$real_number .= '8';
				break;
			case $sig_9:
				$real_number .= '9';
				break;
		}
	}
	$sum += intval($real_number);
}
echo $sum."\n";

function sort_signal($signal) {
	$chars = str_split($signal);
	sort($chars);
	return implode($chars);
}

?>