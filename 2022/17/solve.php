<?

$lines = file('input.txt', FILE_IGNORE_NEW_LINES);

$wind = $lines[0];
$wind_pos = 0;
$rock_pos = 1;
$max_height = 0;
$cutoff_height = 0;
$height_1 = 0;
$height_2 = 0;
$tot_rocks = 0;
$tot_rocks_1 = 0;
$tot_rocks_2 = 0;
$grid = array();

// part 1
while($tot_rocks < 1000000000000) {
	if($rock_pos == 1) {
		/*
		####
		*/
		$rock = array(array($max_height+4, 2), array($max_height+4, 3), array($max_height+4, 4), array($max_height+4, 5));
	} elseif($rock_pos == 2) {
		/*
		.#.
		###
		.#.
		*/
		$rock = array(array($max_height+4, 3), array($max_height+5, 2), array($max_height+5, 3), array($max_height+5, 4), array($max_height+6, 3));
	} elseif($rock_pos == 3) {
		/*
		..#
		..#
		###
		*/
		$rock = array(array($max_height+4, 2), array($max_height+4, 3), array($max_height+4, 4), array($max_height+5, 4), array($max_height+6, 4));
	} elseif($rock_pos == 4) {
		/*
		#
		#
		#
		#
		*/
		$rock = array(array($max_height+4, 2), array($max_height+5, 2), array($max_height+6, 2), array($max_height+7, 2));
	} elseif($rock_pos == 5) {
		/*
		##
		##
		*/
		$rock = array(array($max_height+4, 2), array($max_height+4, 3), array($max_height+5, 2), array($max_height+5, 3));
	}

	$fall = true;
	// while can fall
	while($fall) {
		// wind push
		$move = true;
		$new_rock = array();
		if($wind[$wind_pos] == '<') {
			// move left
			foreach($rock as $r) {
				if($r[1] == 0)
					$move = false;
				if(in_array(array($r[0], $r[1]-1), $grid))
					$move = false;
			}
			if($move)
				foreach($rock as $r)
					$new_rock[] = array($r[0], $r[1]-1);
		} else {
			// move right
			foreach($rock as $r) {
				if($r[1] == 6)
					$move = false;
				if(in_array(array($r[0], $r[1]+1), $grid))
					$move = false;
			}
			if($move)
				foreach($rock as $r)
					$new_rock[] = array($r[0], $r[1]+1);
		}
		if($move)
			$rock = $new_rock;

		$wind_pos++;
		if($wind_pos == strlen($wind))
			$wind_pos = 0;

		// fall down
		foreach($rock as $r) {
			if($r[0] == 1)
				$fall = false;
			if(in_array(array($r[0]-1, $r[1]), $grid))
				$fall = false;
		}
		if($fall) {
			$new_rock = array();
			foreach($rock as $r)
				$new_rock[] = array($r[0]-1, $r[1]);
			$rock = $new_rock;
		} else {
			$grid = array_merge($grid, $rock);
		}

		// if pattern found speed up grid filling
		if($wind_pos == 0) {
			if($height_1 == 0) {
				// first chunk
				$height_1 = $max_height;
				$tot_rocks_1 = $tot_rocks;
			} elseif($height_2 == 0) {
				// repeating chunk
				$height_2 = $max_height - $height_1;
				$tot_rocks_2 = $tot_rocks - $tot_rocks_1;
				$steps = intdiv((1000000000000 - $tot_rocks_1 - $tot_rocks_2), $tot_rocks_2);
				$tot_rocks += $tot_rocks_2 * $steps;
				$max_height += $height_2 * $steps;
				foreach($grid as $k => $g)
					$grid[$k][0] += ($height_2 * $steps);
				foreach($rock as $k => $g)
					$rock[$k][0] += ($height_2 * $steps);
			} 
		}
	}

	// new max height
	foreach($grid as $g)
		$max_height = max($max_height, $g[0]);
		
	// answer to part 1
	if($tot_rocks == 2022)
		echo $max_height."\n";

	// remove unnecessary bottom of the grid
	if(($max_height > $cutoff_height + 50) && ($max_height % 100 == 0)) {
		for($h = $cutoff_height + 1; $h < $max_height; $h++) {
			$found = true;
			for($i = 0; $i < 7; $i++)
				if(!in_array(array($h, $i), $grid) && !in_array(array($h+1, $i), $grid))
					$found = false;
			if($found) {
				$cutoff_height = $h;
				foreach($grid as $k => $g)
					if($g[0] < $cutoff_height)
						unset($grid[$k]);
			}
		}
	}

	if($rock_pos++ == 5)
		$rock_pos = 1;

	$tot_rocks++;
}

// part 2
echo $max_height."\n";

?>