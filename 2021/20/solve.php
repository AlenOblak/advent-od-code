<?

$lines = file('input.txt', FILE_IGNORE_NEW_LINES);

// part 1 and 2
$enhance = $lines[0];
for($i = 2; $i < count($lines); $i++)
	$image[] = $lines[$i];

$step = 0;
while($step < 50) {
	$new_image = '';
	for($y = -1; $y < count($image)+1; $y++) {
		$new_line = '';
		for($x = -1; $x < strlen($image[0])+1; $x++) {
			$pixels  = pix_or_black($image[$y-1][$x-1]).pix_or_black($image[$y-1][$x]).pix_or_black($image[$y-1][$x+1]);
			$pixels .= pix_or_black($image[$y][$x-1])  .pix_or_black($image[$y][$x])  .pix_or_black($image[$y][$x+1]);
			$pixels .= pix_or_black($image[$y+1][$x-1]).pix_or_black($image[$y+1][$x]).pix_or_black($image[$y+1][$x+1]);
			$pixels = str_replace('.', '0', $pixels);
			$pixels = str_replace('#', '1', $pixels);
			$pixels = base_convert($pixels, 2, 10);
			$new_line .= $enhance[$pixels];
		}
		$new_image[] = $new_line;
	}
	$step++;
	$image = $new_image;
	if($step == 2 || $step == 50) {
		$count = 0;
		for($y = 0; $y < count($image); $y++)
			for($x = 0; $x < strlen($image[0]); $x++)
				if($image[$y][$x] == '#')
					$count++;
		echo $count."\n";
	}
}

function pix_or_black($pix) {
	global $step;
	if($pix != '')
		return $pix;
	if($step%2 == 0)
		return '.';
	return '#';
}

?>